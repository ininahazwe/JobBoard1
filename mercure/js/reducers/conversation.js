import {GET_CONVERSATIONS, GET_MESSAGES, SET_LAST_MESSAGE} from "../constants/actionTypes";

export default (state = {
    items: []
}, action) => {
    switch (action.type) {
        case GET_CONVERSATIONS:
            return {
                ...state,
                items: action.items,
            }
        case GET_MESSAGES:
            const _newConversations = state.items.map((conversation) => {
                return conversation.conversationId === action.conversationId
                        ? Object.assign({}, conversation, {messages: action.messages})
                        : conversation
                        ;
            });
            return {
                ...state,
                items: _newConversations
            };
        case SET_LAST_MESSAGE:
            const _newItemsFinal2 = state.items.map(item => {
                return item.conversationId == action.conversationId
                        ?
                        (
                                item.content = action.message.content,
                                        item.createdAt = action.message.createdAt,
                                        Object.assign({}, item)
                        )
                        : Object.assign({}, item);
            });
            return {
                ...state,
                isFetching: false,
                didInvalidate: false,
                items: [..._newItemsFinal2]
            };
        default:
            return state;
    }

}