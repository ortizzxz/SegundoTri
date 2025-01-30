import { Link, useNavigate } from "react-router-dom";
import {
  signInWithPopup,
  GoogleAuthProvider,
  signInWithEmailAndPassword,
} from "firebase/auth";
import { auth } from "../firebase";
import { useState } from "react";
import { signInWithRedirect } from "firebase/auth";

function Login() {
  const provider = new GoogleAuthProvider();
  const navigate = useNavigate();

  function loginGoogle() {
    console.log('Start google sign in');
    
    const isMobile =
      /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
        navigator.userAgent
      );
  
    if (isMobile) {
      signInWithRedirect(auth, provider)
    .then(() => {
      console.log("Redirect initiated"); // Debugging line
    })
    .catch((error) => {
      console.error("Google Sign-In Redirect Error:", error);
    });
    } else {
      signInWithPopup(auth, provider)
        .then((result) => {
          console.log("Sign-in successful", result.user);
          navigate("/game");
        })
        .catch((error) => {
          console.error("Google Sign-In Error", error);
        });
    }
  }
  

  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");

  function loginUserPassword() {
    signInWithEmailAndPassword(auth, email, password)
      .then(() => {
        navigate("/");
      })
      .catch((error) => {
        const errorCode = error.code;
        const errorMessage = error.message;

        if (errorCode === "auth/user-not-found") {
          setError("User not found. Please check your email or sign up.");
        } else if (errorCode === "auth/wrong-password") {
          setError("Incorrect password. Please try again.");
        } else if (errorCode === "auth/invalid-credential") {
          setError("Incorrect credentials. Please try again.");
        } else if (errorCode === "auth/invalid-email") {
          setError(
            "Invalid email format. Please provide a valid email address."
          );
        } else {
          setError("Error signing in: " + errorMessage);
        }
      });
  }

  return (
    <>
      <div className="container mt-3">
        <div className="row justify-content-center">
          <div className="col-md-6">
            <div className="card shadow-lg bg-light p-4">
              <h3 className="text-center mb-4">Iniciar Sesión</h3>
              <form onSubmit={(e) => e.preventDefault()}>
                <div className="mb-3">
                  <label htmlFor="email" className="form-label">
                    Dirección Email
                  </label>
                  <input
                    type="email"
                    className="form-control"
                    id="email"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    placeholder="tu@correo.com"
                    required
                  />
                </div>
                <div className="mb-3">
                  <label htmlFor="password" className="form-label">
                    Contraseña
                  </label>
                  <input
                    type="password"
                    className="form-control"
                    id="password"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    autoComplete="on"
                    placeholder="Tu contraseña"
                    required
                  />
                </div>
                {error && <div className="alert alert-danger">{error}</div>}
                <div className="d-grid gap-2">
                  <button
                    type="button"
                    onClick={loginUserPassword}
                    className="btn login-button"
                  >
                    Log In
                  </button>
                  <button
                    type="button"
                    onClick={loginGoogle}
                    className="btn google-button"
                  >
                    <i className="bi bi-google"></i> Log In con Google
                  </button>
                </div>
              </form>
              <div className="text-center mt-3">
                <p>
                  ¿No tienes una cuenta?{" "}
                  <Link to="/register">Registrate aquí</Link>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </>
  );
}

export default Login;
