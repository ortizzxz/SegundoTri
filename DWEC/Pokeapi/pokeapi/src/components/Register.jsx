import { Link, useNavigate } from "react-router-dom";
import { createUserWithEmailAndPassword, updateProfile } from "firebase/auth";
import { auth } from "../firebase";
import { useState } from "react";

function Register() {
    const [name, setName] = useState('');
    const [email, setEmail] = useState('');
    const [pass1, setPassword1] = useState('');
    const [pass2, setPassword2] = useState('');
    const [error, setError] = useState('');
    const navigate = useNavigate();

    function register() {
        if (!email || !pass1 || !pass2 || !name) {
            setError("Todos los campos son obligatorios");
            return;
        }

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            setError("Ingresa un email válido");
            return;
        }

        if (pass1 !== pass2) {
            setError("Las contraseñas no coinciden");
            return;
        }

        createUserWithEmailAndPassword(auth, email, pass1)
            .then((userCredential) => {
                const user = userCredential.user;
                updateProfile(user, { displayName: name }).then(() => {
                    navigate("/");
                });
            })
            .catch((error) => {
                switch (error.code) {
                    case 'auth/email-already-in-use':
                        setError("Email ya registrado");
                        break;
                    case 'auth/invalid-email':
                        setError("Email inválido");
                        break;
                    case 'auth/weak-password':
                        setError("La contraseña es muy débil. Debe contener mínimo 6 carácteres");
                        break;
                    default:
                        setError("Error al registrar el usuario.");
                        console.error("Authentication error:", error);
                }
            });
    }

    return (
        <>
            <div className="container mt-5">
                <div className="row justify-content-center">
                    <div className="col-md-6">
                        <div className="card shadow-lg p-4">
                            <h3 className="text-center mb-4">Registrarse</h3>
                            <form onSubmit={(e) => e.preventDefault()}>
                                <div className="mb-3">
                                    <label htmlFor="name" className="form-label">Nombre</label>
                                    <input type="text" className="form-control" id="name" value={name} onChange={(e) => setName(e.target.value)} required />
                                </div>
                                <div className="mb-3">
                                    <label htmlFor="email" className="form-label">Dirección Email</label>
                                    <input type="email" className="form-control" id="email" value={email} onChange={(e) => setEmail(e.target.value)} required />
                                </div>
                                <div className="mb-3">
                                    <label htmlFor="password" className="form-label">Contraseña</label>
                                    <input type="password" className="form-control" id="password" value={pass1} onChange={(e) => setPassword1(e.target.value)} autoComplete="on" required />
                                </div>
                                <div className="mb-3">
                                    <label htmlFor="confirm-password" className="form-label">Confirmar Contraseña</label>
                                    <input type="password" className="form-control" id="confirm-password" value={pass2} onChange={(e) => setPassword2(e.target.value)} autoComplete="on" required />
                                </div>
                                {error && <div className="alert alert-danger">{error}</div>}
                                <div className="d-grid gap-2">
                                    <button type="button" onClick={register} className="btn btn-success">Registrarse</button>
                                </div>
                            </form>
                            <div className="text-center mt-3">
                                <p>¿Ya tienes una cuenta? - <Link to="/login">Inicia sesión aquí</Link></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}

export default Register;
