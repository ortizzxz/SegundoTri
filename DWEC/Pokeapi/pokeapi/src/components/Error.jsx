import { Link } from "react-router-dom";

function Error() {
    return (
        <>
            <div className="page-heading bg-light header-text mt-2" style={{ backgroundColor: '#f8d030' }}>
                <div className="container">
                    <div className="row">
                        <div className="col-lg-12 text-center">
                            <h1 style={{ fontFamily: 'Pokemon', color: '#4c4c4c' }}>404 - oops.</h1>
                        </div>
                    </div>
                </div>
            </div>

            <div className="section categories" style={{ backgroundColor: '#f7f7f7' }}>
                <div className="container">
                    <div className="row">
                        <div className="col-lg-12 text-center">
                            <div className="section-heading">
                                <h2 style={{ fontFamily: 'Pokemon', color: '#4c4c4c' }}>El pókemon que estás buscando no se ha encontrado.</h2>
                                <p style={{ fontSize: '18px', color: '#555' }}>
                                    Parece que te has perdido en la selva - intenta ir a la página principal o atrapar a otro pókemon.
                                </p>
                                <div>
                                    <Link to="/" className="btn btn-primary" style={{ backgroundColor: '#ffcc00', color: '#fff', padding: '10px 20px', fontSize: '16px' }}>
                                        Volver a la página principal
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </>
    );
}

export default Error;
