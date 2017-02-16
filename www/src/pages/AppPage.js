"use strict";

import React from 'react';
import AppContainer from '../containers/AppContainer';

/**
 * Application component
 *
 * This is the parent component for all routes in the application. It displays
 * the header and wraps the content of the current route in a container div.
 */
class AppPage extends React.Component {

	render() {
		return (
			<AppContainer>
				{this.props.children}
			</AppContainer>
		);
	}
}

export default AppPage;