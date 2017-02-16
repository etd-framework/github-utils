import React from 'react';

export default ({ input, label, type, meta: { touched, error, invalid, warning } }) => (
    <div className={`form-group ${touched && invalid ? 'has-error' : ''}`}>
        <input {...input} className="form-control" placeholder={label} type={type}/>
    </div>
);