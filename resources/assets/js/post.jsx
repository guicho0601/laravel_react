import React from 'react';
import ReactDOM from 'react-dom';
import moment from 'moment';
import NProgress from 'nprogress';

import CommentForm from './CommentForm.jsx';
import CommentsList from './CommentsList.jsx';

var PostList = React.createClass({
    render: function() {
        var postNodes = this.props.data.map(function (post) {
            return (
                <div className="panel panel-primary" key={post.id_post}>
                    <div className="panel-heading">{post.r_autor.nickname} - {post.tiempo}</div>
                    <div className="panel-body">
                        {post.contenido}
                    </div>
                    <table className="table">
                        <CommentsList data={post.comentarios}/>
                    </table>
                    <div className="panel-footer">
                        <CommentForm id_post={post.id_post} actualizar={this.props.actualizar}/>
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
    loadCommentsFromServer(data){
        if(data==null){
            $.ajax({
                url: this.props.url,
                type: 'GET',
                dataType: 'json',
                cache: false,
                beforeSend: function(){
                    NProgress.start();
                },
                success: function(data) {
                    this.setState({data: data});
                }.bind(this),
                error: function(xhr, status, err) {
                    console.error(this.props.url, status, err.toString());
                }.bind(this),
                complete: function(){
                    NProgress.done();
                }
            });
        }else{
            this.setState({data:JSON.parse(data)});
        }
    },
    getInitialState: function() {
        return {data: []};
    },
    componentDidMount: function() {
        this.loadCommentsFromServer();
        var socket = io.connect('http://localhost:8890');
        socket.on('post', this.loadCommentsFromServer);
    },
    render: function() {
        return (
            <div>
                <h1>Post</h1>
                <PostList data={this.state.data} actualizar={this.loadCommentsFromServer}/>
            </div>
        );
    }
});

ReactDOM.render(
    <PostBox url={global_url+"/post"} pollInterval={10000} />,
    document.getElementById('lista_posts')
);