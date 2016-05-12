var React = require('react');
var ReactDOM = require('react-dom');

module.exports = React.createClass({
    getInitialState: function() {
        return {comment:''}
    },
    submit: function(e) {
        e.preventDefault();
        if(this.state.comment != ''){
            $.ajax({
                type: 'POST',
                url: global_url+'/post/'+this.props.id_post+'/comentario',
                data:{
                    comentario: this.state.comment,
                    _token: csrf_token
                },
                success: function () {
                    this.setState({comment: ""});
                }.bind(this),
                complete: function () {
                    $(this.state.boton).html('Comentar');
                }.bind(this)
            }).fail(function(jqXhr) {
                console.log('failed to register');
            });
        }
    },
    commentChange: function(e){
        this.setState({comment: e.target.value})
    },
    buttonClick: function(e){
        this.setState({
            boton: e.target
        });

        $(e.target).html('<i class="fa fa-spinner fa-pulse"></i>');
    },
    render: function () {
        return (
            <div className="row">
                <form className="form" key={this.props.id_post} onSubmit={this.submit}>
                    <div className="col-md-10">
                        <input type="text" placeholder="Que estas pensando..." className="form-control" value={this.state.comment} onChange={this.commentChange} />
                    </div>
                    <div className="col-md-2">
                        <button type="submit" disabled={!this.state.comment} className="btn btn-primary" onClick={this.buttonClick}>Comentar</button>
                    </div>
                </form>
            </div>
        );
    }
});