import axios from 'axios';
import {API_ROOT} from '../constants';

// Login
export const LOGIN = 'LOGIN';
export const LOGIN_SUCCESS = 'LOGIN_SUCCESS';
export const LOGIN_FAILURE = 'LOGIN_FAILURE';

export function login(formValues) {

    const request = axios.post(`${API_ROOT}/login`, formValues, {

    });

    return {
        type: LOGIN,
        payload: request
    };
}

export function loginSuccess(data) {
    return {
        type: LOGIN_SUCCESS,
        payload: data
    };
}

export function loginFailure(error) {
    return {
        type: LOGIN_FAILURE,
        payload: error
    };
}