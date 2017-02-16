"use strict";

/**
 * This is the entry point for the webpack bundle.
 *
 * Import any libraries needed across the whole application. Define navigation
 * routes and import the top-level component for each route.
 */

import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';
import { Router, browserHistory } from 'react-router';
import routes from './routes';
import configureStore from './store';

const store = configureStore();

console.log('app.js');

ReactDOM.render((
	<Provider store={store}>
		<Router history={browserHistory} routes={routes} />
	</Provider>
), document.getElementById('etdapp'));