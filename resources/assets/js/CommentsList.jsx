var React = require('react');
var ReactDOM = require('react-dom');

var commentStyle = {
    paddingLeft: '30px'
};

module.exports = React.createClass({
    render: function () {
        var commentNode = this.props.data.map(function (comment) {
            return (
                <tr key={comment.id_comentario}>
                    <td style={commentStyle}>
                        {comment.r_autor.nickname} - {comment.tiempo} <br/>
                        {comment.comentario}
                    </td>
                </tr>
            );
        });
        return (
            <tbody>
            {commentNode}
            </tbody>
        );
    }
});