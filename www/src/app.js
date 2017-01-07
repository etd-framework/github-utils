"use strict";

/**
 * This is the entry point for the webpack bundle.
 *
 * Import any libraries needed across the whole application. Define navigation
 * routes and import the top-level component for each route.
 */

import React from 'react';
import { render } from 'react-dom';
import { Router, Route, IndexRoute, Redirect } from 'react-router';
import history from './history.js';
import App from './components/App.js';
import LoginPage from './components/login/LoginPage.js';

console.log('app.js');

render((
	<Router history={history}>
		<Route path="/" component={App}>
			<IndexRoute component={LoginPage} />
			<Redirect from="*" to="/" />
		</Route>
	</Router>
), document.getElementById('etdapp'));