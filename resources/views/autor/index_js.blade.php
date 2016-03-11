var SelectPaises = React.createClass({
    render:function(){
        var paises = JSON.parse('<?=json_encode($paises)?>');
        var opciones = paises.map(function(pais){
            return(<option value={pais.id_pais} key={pais.id_pais}>{pais.nombre}</option>);
        });
        return(
            <select name="id_pais" ref="id_pais" className="form-control" value={this.props.valor} onChange={this.props.handler!=null?this.props.handler:null}>
                {opciones}
            </select>
        );
    }
});

var ItemAutor = React.createClass({
    getInitialState(){return {nickname:this.props.autor.nickname,correo:this.props.autor.correo,id_pais:this.props.autor.id_pais,editando:false}},
    editar(){this.setState({editando:true});},
    cancelar(){this.setState({nickname:this.props.autor.nickname,correo:this.props.autor.correo,id_pais:this.props.id_pais,editando:false});},
    actualizar(){
        $.ajax({
            url:'<?=url('autor')?>/'+this.props.autor.id_autor,
            type:'POST',
            dataType:'json',
            cache:false,
            data:{
                _method:'PATCH',
                _token:'<?=csrf_token()?>',
                nickname:this.state.nickname,
                correo:this.state.correo,
                id_pais:this.state.id_pais
            },
            success:function(){
                this.props.actualizar();
                this.cancelar();
            }.bind(this),
            error: function(xhr, status, err) {
                console.error(status, err.toString());
            }
        });
    },
    handlerNickname(e){this.setState({nickname:e.target.value})},
    handlerCorreo(e){this.setState({correo:e.target.value})},
    handlerIdPais(e){this.setState({id_pais:e.target.value})},
    eliminar(){
        $.confirm({
            title: 'Confirmar!',
            content: 'Desea eliminar al usuario '+this.props.autor.nickname+'!',
            confirm: function(){
                $.ajax({
                    url:'<?=url('autor')?>/'+this.props.autor.id_autor,
                    type:'POST',
                    dataType:'json',
                    cache:false,
                    data:{
                        _method:'DELETE',
                        _token:'<?=csrf_token()?>',
                    },
                    success:function(){
                        this.props.actualizar();
                    }.bind(this),
                    error: function(xhr, status, err) {
                        console.error(status, err.toString());
                    }
                });
            }.bind(this)
        });
    },
    render:function(){
        var autor = this.props.autor;
        if(this.state.editando){
            return(
                <tr>
                    <td>{this.props.index+1}</td>
                    <td><input type="text" value={this.state.nickname} onChange={this.handlerNickname} className="form-control"/></td>
                    <td><input type="text" value={this.state.correo} onChange={this.handlerCorreo} className="form-control"/></td>
                    <td><SelectPaises handler={this.handlerIdPais} valor={this.state.id_pais}/></td>
                    <td>{autor.no_posts}</td>
                    <td>
                        <button className="btn btn-primary btn-sm" onClick={this.actualizar}>Guardar</button> <button className="btn btn-danger btn-sm" onClick={this.cancelar}>Cancelar</button>
                    </td>
                </tr>
            );
        }else{
            return(
                <tr>
                    <td>{this.props.index+1}</td>
                    <td>{autor.nickname}</td>
                    <td>{autor.correo}</td>
                    <td>{autor.pais.nombre}</td>
                    <td>{autor.no_posts}</td>
                    <td><button className="btn btn-warning btn-sm" onClick={this.editar}><i className="fa fa-pencil-square-o"></i></button> <button className="btn btn-danger btn-sm" onClick={this.eliminar}><i className="fa fa-trash"></i></button></td>
                </tr>
            );
        }
    }
});

var ListaAutores = React.createClass({
    render:function(){
        var autores = this.props.autores.map(function(autor,index){
            return(<ItemAutor autor={autor} index={index} key={autor.id_autor} actualizar={this.props.actualizar}/>);
        }.bind(this));
        return(
            <tbody key="autores">
                {autores}
            </tbody>
        );
    }
});

var AgregarNuevoAutor = React.createClass({
    insertar(){
        $.ajax({
            url:'<?=url('autor')?>',
            type:'POST',
            cache:false,
            dataType:'json',
            data:{
                _token: '<?=csrf_token()?>',
                nickname: this.refs.nickname.value,
                correo: this.refs.correo.value,
                id_pais: this.refs.select_pais.refs.id_pais.value
            },
            success:function(){
                this.props.actualizar();
                this.cancelar();
            }.bind(this),
            error: function(xhr, status, err) {
                console.error(status, err.toString());
            }
        });
    },
    cancelar(){
        this.refs.nickname.value = '';
        this.refs.correo.value = '';
        this.refs.select_pais.refs.id_pais.value=1;
    },
    render:function(){
        return(
            <tr>
                <td><i className="fa fa-plus"></i></td>
                <td><input type="text" ref="nickname" className="form-control"/></td>
                <td><input type="text" ref="correo" className="form-control"/></td>
                <td><SelectPaises ref="select_pais" key="select-paises" valor={0}/></td>
                <td><button className="btn btn-primary btn-block" onClick={this.insertar}>Guardar</button></td>
                <td><button className="btn btn-danger btn-block" onClick={this.cancelar}>Cancelar</button></td>
            </tr>
        );
    }
});

var CajaAutores = React.createClass({
    cargarDesdeServidor(){
        $.ajax({
            url: '<?=url('autor')?>',
            type: 'GET',
            dataType: 'json',
            cache: false,
            success:function(data){
                this.setState({autores:data});
            }.bind(this),
            error:function(xhr, status){
                console.log(xhr, status);
            }
        });
    },
    getInitialState(){
        return {autores:[]};
    },
    componentDidMount(){
        this.cargarDesdeServidor();
        setInterval(this.cargarDesdeServidor, 15000);
    },
    render: function () {
        return(
            <table className="table table-bordered table-hover table-condensed" key="tabla-autores">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>País</th>
                        <th>Posts</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <ListaAutores autores={this.state.autores} actualizar={this.cargarDesdeServidor}/>
                <tfoot>
                    <AgregarNuevoAutor actualizar={this.cargarDesdeServidor}/>
                </tfoot>
            </table>
        );
    }
});

ReactDOM.render(
    <CajaAutores/>,
    document.getElementById('todo')
);