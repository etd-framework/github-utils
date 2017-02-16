import { connect } from 'react-redux';
import LoginComponent from '../components/LoginComponent.js';

const mapDispatchToProps = (dispatch) => {
    return {
        resetMe: () => {

        }
    }
}


function mapStateToProps(state, ownProps) {
    return {
        data: state.data
    };
}

export default connect(mapStateToProps, mapDispatchToProps)(LoginComponent);