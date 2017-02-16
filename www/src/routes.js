
import React from 'react';
import { Route, IndexRoute } from 'react-router';

import AppPage from './pages/AppPage.js';
import LoginPage from './pages/LoginPage.js';
import ActionsPage from './pages/ActionsPage.js';
import RunPage from './pages/RunPage.js';

export default (
    <Route path="/" component={AppPage}>
        <IndexRoute component={LoginPage} />
        <Route path="/actions" component={ActionsPage} />
        <Route path="/run" component={RunPage} />
    </Route>
);