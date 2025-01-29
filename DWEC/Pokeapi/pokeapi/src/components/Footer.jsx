function Footer() {
    return (
        <footer className="text-black py-4 mt-2" style={{ backgroundColor: '#FFCC00' }}>
            <div className="container text-center">
                <div className="row">
                    <div className="col-md-4">
                        <h5>About.</h5>
                        <p>Este proyecto ha sido realizado como uno de los principales para el módulo de DWEC. Haciendo uso de React + Vite, Bootstrap</p>
                    </div>
                    <div className="col-md-4">
                        <h5>Quick Links</h5>
                        <ul className="list-unstyled d-flex justify-content-center gap-3">
                            <li><i className="bi bi-house-door me-2"></i><a href="/" className="text-dark">Home</a></li>
                            <li><i className="bi bi-controller me-2"></i><a href="/game" className="text-dark">Game</a></li>
                            <li><i className="bi bi-person-plus me-2"></i><a href="/register" className="text-dark">Register</a></li>
                            <li><i className="bi bi-box-arrow-in-right me-2"></i><a href="/login" className="text-dark">Login</a></li>
                        </ul>
                    </div>
                    <div className="col-md-4">
                        <h5>Follow Us</h5>
                        <a href="#" className="text-dark me-3"><i className="bi bi-facebook"></i></a>
                        <a href="#" className="text-dark me-3"><i className="bi bi-twitter"></i></a>
                        <a href="#" className="text-dark"><i className="bi bi-instagram"></i></a>
                    </div>
                </div>
            </div>
        </footer>
    );
}

export default Footer;