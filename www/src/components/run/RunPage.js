"use strict";

import React from 'react';

/**
 * Run Page
 */
let RunPage = React.createClass({
	componentDidMount: function() {
		console.log('RunPage.js');
	},
	render: function() {
		return (
			<div>
				<h2>Run</h2>
			</div>
		);
	}
});

export default RunPage;