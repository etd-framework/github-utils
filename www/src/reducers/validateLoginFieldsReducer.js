
import { VALIDATE_LOGIN_FIELDS, VALIDATE_LOGIN_FIELDS_SUCCESS, VALIDATE_LOGIN_FIELDS_FAILURE, RESET_VALIDATE_LOGIN_FIELDS} from '../actions/validateLoginFields';


//user = userobj,
// status can be:
// 1. 'storage' ie. localstorage / sessionstorage)
// 2. 'signup' (signing up)
// 3. 'signin' (signing in)
// 4. 'validate'(validate fields)
// 5. 'validate_email' (validating email token)
// 5. 'authenticated'(after signin)
// 6. 'logout' (after logout)

const INITIAL_STATE = {
    error: null,
    loading: false
};

export default function(state = INITIAL_STATE, action) {

    let error;

    switch(action.type) {

        case VALIDATE_LOGIN_FIELDS: // login form fields

            return {
                ...state,
                error: null,
                loading: true
            };

        case VALIDATE_LOGIN_FIELDS_SUCCESS:// same as RESET_USER_FIELDS

            return {
                ...state,
                error: null,
                loading: false
            };

        case VALIDATE_LOGIN_FIELDS_FAILURE:
            error = action.payload.data ? action.payload.data : {message: action.payload.message};

            return {
                ...state,
                error: error,
                loading: false
            };

        case RESET_VALIDATE_LOGIN_FIELDS:

            return {
                ...state,
                error: null,
                loading: false
            };

        default:

            return state;
    }
}