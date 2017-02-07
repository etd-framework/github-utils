"use strict";

import React from 'react';
import '../scss/bootstrap.scss';
import '../scss/utilities/_display.scss';
import '../scss/app.scss';

/**
 * Application component
 *
 * This is the parent component for all routes in the application. It displays
 * the header and wraps the content of the current route in a container div.
 */
class App extends React.Component {

	componentDidMount() {
		console.log('App.js');
	}

	render() {
		return (
			<div className="d-table w-100 h-100">
				<div className="d-tablecell align-middle p-2">
					{this.props.children}
				</div>
			</div>
		);
	}
}

export default App;