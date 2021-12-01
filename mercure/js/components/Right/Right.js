import React from 'react';
import Input from "./Input";
import Message from "./Message";
import {connect} from 'react-redux'
import * as actionCreators from '../../actions/conversation'

const mapStateToProps = (state) => {
    return state;
}

class Right extends React.Component {

    constructor(props) {
        super(props);
        this.bodyRef = React.createRef();
        this.state = {
            id: null,
            _conversationIndex: -1,
            eventSource: null
        }
    }

    scrollDown() {
        this.bodyRef.current.scrollTop = this.bodyRef.current.scrollHeight;
    }

    componentDidMount() {
        this.props.fetchMessages(this.props.match.params.id)
                .then(() => {
                    this.scrollDown();
                });
    }

    componentWillMount() {
        console.log("unmounted");
    }

    render() {
        const _conversationIndex = this.props.items.findIndex(conversation => {
            return conversation.conversationId === this.props.match.params.id
        })

        return (
                <div className="col-7 px-0">
                    <div className="px-4 py-5 chat-box bg-white" ref={this.bodyRef}>
                        {
                            _conversationIndex !== -1 ?
                            this.props.items[_conversationIndex].messages
                                    ?.map((messages, index) => {
                                        return (
                                                <Message message={message} key={index}/>
                                        )
                                    })
                                    : ''
                        }
                    </div>

                    <Input id={this.props.match.params.id}/>
                </div>
        );
    }
}

export default connect(mapStateToProps, actionCreators)(Right);