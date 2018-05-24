
<html>
    <head>
        <meta charset="UTF-8">
        <title>Prueba</title>
        <link rel="stylesheet" href="css/estilos.css"type="text/css">
        <link rel="stylesheet" href="css/core/bootstrap.min.css" type="text/css">
        <script src="js/core/bootstrap.min.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="#"> REGISTRAR <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">BUSCAR</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">MODIFICAR</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">Disabled</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <h4>FORMULARIO</h4>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <label>codigo</label>
                                    <input type="text" class="form-control" placeholder="ingrese codigo" name="codigo" id="codigo">
                                </div>
                                <div class="form-group">
                                    <label>nombre</label>
                                    <input type="text" class="form-control" placeholder="ingrese nombre"name="nombre" id="nombre">
                                </div>
                            </form>
                        </div>
                        <div class="card-footer">
                            <p>pie de form</p>
                        </div>   
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
