"use strict";

import React from 'react';
import { reduxForm, Field, SubmissionError } from 'redux-form';
import inputField from './fields/inputField';
import { login, loginSuccess, loginFailure, resetLoginFields } from '../actions/login';
import '../scss/components/LoginComponent.scss';

//Client side validation
function validate(values) {

    let errors = {};
    let hasErrors = false;

    if (!values.api_token || values.api_token.trim() === '') {
        errors.api_token = 'Entrez le token API personnel';
        hasErrors = true;
    }

    if (!values.owner || values.owner.trim() === '') {
        errors.owner = 'Entrez le propriétaire';
        hasErrors = true;
    }

    if (!values.repo || values.repo.trim() === '') {
        errors.repo = 'Entrez le repo';
        hasErrors = true;
    }

    return hasErrors && errors;
}

/**
 * Login Component
 */
class LoginComponent extends React.Component {

    componentWillMount() {
        //Important! If your component is navigating based on some global state(from say componentWillReceiveProps)
        //always reset that global state back to null when you REMOUNT
        this.props.resetMe();
    }

    /**
	 * For any field errors upon submission (i.e. not instant check)
	 *
     * @param values
     * @param dispatch
     * @returns {Promise<R2|R1>|*|Promise<R>|Promise.<TResult>}
     */
    validateAndLogin(values, dispatch) {

		return dispatch(login(values))
				.then((result) => {
console.log(result);
					// Note: Error's "data" is in result.payload.response.data (inside "response")
					// success's "data" is in result.payload.data
					if (result.payload.response && result.payload.response.status !== 200) {
						dispatch(loginFailure(result.payload.response.data));
						throw new SubmissionError(result.payload.response.data);
					}

					//Store JWT Token to browser session storage
					//If you use localStorage instead of sessionStorage, then this w/ persisted across tabs and new windows.
					//sessionStorage = persisted only in current tab
					sessionStorage.setItem('jwtToken', result.payload.data.token);
					//let other components know that everything is fine by updating the redux` state
					dispatch(loginSuccess(result.payload.data)); //ps: this is same as dispatching RESET_LOGIN_FIELDS
				});

	};

	render() {

        const {asyncValidating, handleSubmit, submitting} = this.props;

		return (
			<div className="login">
				<div className="cell mx-auto">
					<h1>Connexion à GitHub</h1>

					<form onSubmit={handleSubmit(this.validateAndLogin)}>

						<Field
							name="api_token"
							type="password"
							component={ inputField }
							label="Token API Personnel"
						/>

						<Field
							name="owner"
							type="text"
							component={ inputField }
							label="Propriétaire du repo"
						/>

						<Field
							name="repo"
							type="text"
							component={ inputField }
							label="Nom du repo"
						/>

						<div className="text-center mt-5">
							<button className="btn btn-lg btn-outline-primary" type="submit" disabled={ submitting }>Connexion</button>
						</div>

						<div className="text-center mt-4">
							<a className="btn btn-link text-xs" target="_blank" href="https://github.com/settings/tokens/new">Créer un token</a>
						</div>

					</form>
				</div>
			</div>
		);
	}


}

export default reduxForm({
    form: 'LoginForm', // a unique identifier for this form
    validate // <--- validation function given to redux-form
})(LoginComponent);