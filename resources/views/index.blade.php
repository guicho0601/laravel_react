@extends('app')
@section('content')
    <div id="lista_posts" style="padding-top: 25px;"></div>
@stop
@section('scripts')
    <script type="text/babel">

        var commentStyle = {
            paddingLeft: '30px'
        };

        var CommentForm = React.createClass({
            getInitialState: function() {
                return {}
            },
            submit: function(e) {
                e.preventDefault();
                if(this.state.comment != ''){
                    $.ajax({
                        type: 'POST',
                        url: '<?=url('post')?>/'+this.props.id_post+'/comentario',
                        data:{
                            comentario: this.state.comment,
                            _token: '<?=csrf_token()?>'
                        },
                        success: function (data) {
                            console.log(data);
                            this.setState({
                                comment: ""
                            });
                            this.props.updateFn
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
                this.setState({
                    comment: e.target.value
                })
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
        
        var CommentsList = React.createClass({
            render: function () {
                var commentNode = this.props.data.map(function (comment) {
                    return (
                        <tr key={comment.id_comentario}>
                            <td style={commentStyle}>
                                {comment.autor} - {comment.fh_publicacion} <br/>
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

        var PostList = React.createClass({
            render: function() {
                var postNodes = this.props.data.map(function (post) {
                    return (
                        <div className="panel panel-primary" key={post.id_post}>
                            <div className="panel-heading">{post.autor} - {post.fh_publicacion}</div>
                            <div className="panel-body">
                                {post.contenido}
                            </div>
                            <table className="table">
                                <CommentsList data={post.comentarios} updateFn={this.props.updateFn}/>
                            </table>
                            <div className="panel-footer">
                                <CommentForm id_post={post.id_post}/>
                            </div>
                        </div>
                    );
                }.bind(this));
                return (
                    <div>
                        {postNodes}
                    </div>
                );
            }
        });

        var PostBox = React.createClass({
            loadCommentsFromServer: function() {
                $.ajax({
                    url: this.props.url,
                    dataType: 'json',
                    cache: false,
                    beforeSend: function () {
                        console.log('Hola');
                    },
                    success: function(data) {
                        this.setState({data: data});
                    }.bind(this),
                    error: function(xhr, status, err) {
                        console.error(this.props.url, status, err.toString());
                    }.bind(this)
                });
            },
            getInitialState: function() {
                return {data: []};
            },
            componentDidMount: function() {
                this.loadCommentsFromServer();
                setInterval(this.loadCommentsFromServer, this.props.pollInterval);
            },
            render: function() {
                return (
                    <div>
                        <h1>Post</h1>
                        <PostList data={this.state.data} updateFn={this.loadCommentsFromServer}/>
                    </div>
                );
            }
        });

        ReactDOM.render(
            <PostBox url="<?=url('post')?>" pollInterval={10000} />,
            document.getElementById('lista_posts')
        );
    </script>
@stop