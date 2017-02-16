import axios from 'axios';
import {API_ROOT} from '../constants';

//Validate user fields like name and password
export const VALIDATE_LOGIN_FIELDS = 'VALIDATE_LOGIN_FIELDS';
export const VALIDATE_LOGIN_FIELDS_SUCCESS = 'VALIDATE_LOGIN_FIELDS_SUCCESS';
export const VALIDATE_LOGIN_FIELDS_FAILURE = 'VALIDATE_LOGIN_FIELDS_FAILURE';
export const RESET_VALIDATE_LOGIN_FIELDS = 'RESET_VALIDATE_LOGIN_FIELDS';

export function validateLoginFields(values) {
    //note: we cant have /users/validateFields because it'll match /users/:id path!
    const request = axios.post(`${API_ROOT}/users/validate/fields`, values);

    return {
        type: VALIDATE_LOGIN_FIELDS,
        payload: request
    };
}

export function validateLoginFieldsSuccess() {
    return {
        type: VALIDATE_LOGIN_FIELDS_SUCCESS
    };
}

export function validateLoginFieldsFailure(error) {
    return {
        type: VALIDATE_LOGIN_FIELDS_FAILURE,
        payload: error
    };
}

export function resetValidateLoginFields() {
    return {
        type: RESET_VALIDATE_LOGIN_FIELDS
    }
};

