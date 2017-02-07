"use strict";

import React from 'react';
import rp from 'request-promise';
import { apiUrl } from '../../../src/constants.js';
import './LoginPage.scss';

/**
 * Login Page
 */
class LoginPage extends React.Component {

	componentDidMount() {
		console.log('LoginPage.js');
	}

	handleClick() {
		rp({
			uri: apiUrl,
			json: true,
			qs: { action: 'hello' }
		})
		.then(function(response) {
			console.log(response);
		})
		.catch(function(error) {
			console.log(error);
		});
	}

	render() {
		return (
			<div className="login">
				<div className="cell mx-auto">
					<h1 className="mb-3 mx-auto">Connexion</h1>
					<div className="form-group">

					</div>
					<div className="form-group">

					</div>
					<button className="btn btn-outline-secondary btn-block" type="submit">Connexion</button>
				</div>
			</div>
		);
	}

}

export default LoginPage;