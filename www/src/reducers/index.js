import { combineReducers } from 'redux';
import validateLoginFieldsReducer from './validateLoginFieldsReducer';
import { reducer as formReducer } from 'redux-form';

const rootReducer = combineReducers({
    validateFields: validateLoginFieldsReducer,
    form: formReducer, // <-- redux-form
});

export default rootReducer;