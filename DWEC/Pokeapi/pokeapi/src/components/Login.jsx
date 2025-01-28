import { Link, useNavigate } from "react-router-dom"
import { signInWithPopup, GoogleAuthProvider, signInWithEmailAndPassword } from "firebase/auth";
import { auth } from "../firebase";
import { useState } from "react";

function Login() {

    const provider = new GoogleAuthProvider();
    const navigate = useNavigate();

    function loginGoogle() {
        signInWithPopup(auth, provider)
            .then((result) => {
                // This gives you a Google Access Token. You can use it to access the Google API.
                const credential = GoogleAuthProvider.credentialFromResult(result);
                const token = credential.accessToken;
                // The signed-in user info.
                const user = result.user;
                // IdP data available using getAdditionalUserInfo(result)
                navigate("/game");
            }).catch((error) => {
                // Handle Errors here.
                const errorCode = error.code;
                const errorMessage = error.message;
                // The email of the user's account used.
                const email = error.customData.email;
                // The AuthCredential type that was used.
                const credential = GoogleAuthProvider.credentialFromError(error);
                // ...
            });
    }

    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [error, setError] = useState('');

    function loginUserPassword() {
        signInWithEmailAndPassword(auth, email, password)
            .then((userCredential) => {
                // Signed in 
                const user = userCredential.user;
                navigate("/");
            })
            .catch((error) => {

                // Manejo de errores
                const errorCode = error.code;
                const errorMessage = error.message;

                if (errorCode === 'auth/user-not-found') {
                    setError('User not found. Please check your email or sign up.');
                } else if (errorCode === 'auth/wrong-password') {
                    setError('Incorrect password. Please try again.');
                } else if (errorCode === 'auth/invalid-credential') {
                    setError('Incorrect credentials. Please try again.');
                } else if (errorCode === 'auth/invalid-email') {
                    setError('Invalid email format. Please provide a valid email address.');
                } else {
                    // Otros errores no manejados específicamente
                    setError('Error signing in: ' + errorMessage)
                }
            });

    }

    const handleLogin = (event) => {
        event.preventDefault(); // Evita que el formulario se envíe automáticamente
    };


    return (
        <>
            <div className="page-heading header-text">
                <div className="container">
                    <div className="row">
                        <div className="col-lg-12">
                            <h3>Login</h3>
                            <span className="breadcrumb"><a href="#">Home</a> &gt; Login</span>
                        </div>
                    </div>
                </div>
            </div>


            <div class="contact-page section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 align-self-center">
                            <div class="left-text">
                                <div class="section-heading">
                                    <h6>Log In</h6>
                                    <h2>Welcome back!</h2>
                                </div>
                                Welcome to our login page! Sign in to access your account and unlock a world of possibilities. Your journey starts here.
                                <br /><br />
                                <ul>
                                    <li><span>Dont't have an account? <Link to={"/register"}>Click here</Link></span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="right-content">
                                <div class="row">
                                    <div class="col-lg-12">

                                    </div>
                                    <div class="col-lg-12">
                                        <form id="contact-form" onSubmit={handleLogin}>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <fieldset>
                                                        <h2>Please identify</h2><br /><br />
                                                        <input type="email" name="email" id="email" value={email} onChange={(e) => setEmail(e.target.value)} pattern="[^ @]*@[^ @]*" placeholder="Your E-mail..." required="" />
                                                    </fieldset>
                                                </div>
                                                <div class="col-lg-12">
                                                    <fieldset>
                                                        <input type="password" name="subject" value={password} onChange={(e) => setPassword(e.target.value)} id="subject" placeholder="Password..." autocomplete="on" />
                                                        <p style={{ color: 'red' }}>&nbsp;&nbsp;&nbsp;&nbsp;{error}</p>
                                                    </fieldset>
                                                </div>
                                                <div class="col-lg-12">
                                                    <fieldset>
                                                        <button onClick={loginUserPassword} class="orange-button">Log In</button>
                                                        <br></br><br></br>
                                                        <button onClick={loginGoogle} class="orange-button"><i class="fa-brands fa-google"></i></button>
                                                    </fieldset>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    )
}

export default Login