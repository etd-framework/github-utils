import { connect } from 'react-redux';
import AppComponent from '../components/AppComponent.js';

const mapDispatchToProps = (dispatch) => {
    return {
        resetMe: () => {

        }
    }
}


function mapStateToProps(state, ownProps) {
    return {

    };
}

export default connect(mapStateToProps, mapDispatchToProps)(AppComponent);