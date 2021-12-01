import React from 'react';
import ReactDOM from 'react-dom';
import store from './store';
import App from "./components/App";
import {Provider} from 'react-redux';
import {MemoryRouter} from 'react-router-dom';

ReactDOM.render((
        <Provider store={store}>
            <MemoryRouter>
                <App/>
            </MemoryRouter>
        </Provider>
), document.getElementById('app'));