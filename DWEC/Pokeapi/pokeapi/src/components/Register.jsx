import { Link, useNavigate } from "react-router-dom"
import { createUserWithEmailAndPassword, updateProfile} from "firebase/auth";
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
        // Validate empty fields
        if (!email || !pass1 || !pass2 || !name) {
            setError("All fields are mandatory");
            return;
        }

        // Validate email format
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            setError("Enter a valid email");
            return;
        }

        // Validate matching passwords
        if (pass1 !== pass2) {
            setError("Passwords do not match");
            return;
        }
        createUserWithEmailAndPassword(auth, email, pass1)
            .then((userCredential) => {

                const user = userCredential.user;
                updateProfile(user, {
                    displayName: name
                }).then(() => {
                    navigate("/");
                })
            })
            .catch((error) => {
                switch (error.code) {
                    case 'auth/email-already-in-use':
                        setError("Email is already registered");
                        break;
                    case 'auth/invalid-email':
                        setError("Invalid email");
                        break;
                    case 'auth/weak-password':
                        setError("Weak password, it must be at least 6 characters");
                        break;
                    default:
                        setError("Error while registering the user");
                        console.error("Authentication error:", error);
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
                            <h3>Register</h3>
                            <span className="breadcrumb"><a href="#">Home</a> &gt; Register</span>
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
                                    <h6>Register</h6>
                                    <h2>Welcome!</h2>
                                </div>
                                Welcome to our registration page! Begin your journey by creating an account and accessing a world of opportunities. Your adventure starts right here.
                                <br /><br />
                                <ul>
                                    <li><span>Already have an account? <Link to={"/login"}>Click here</Link></span></li>
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
                                                        <h2>Please register</h2><br /><br />
                                                        <input type="text" name="name" id="name" value={name} onChange={(e) => setName(e.target.value)} placeholder="Your Name..." required="" />
                                                    </fieldset>
                                                </div>
                                                <div class="col-lg-12">
                                                    <fieldset>
                                                        <input type="email" name="email" id="email" value={email} onChange={(e) => setEmail(e.target.value)} pattern="[^ @]*@[^ @]*" placeholder="Your E-mail..." required="" />
                                                    </fieldset>
                                                </div>
                                                <div class="col-lg-12">
                                                    <fieldset>
                                                        <input type="password" name="subject" value={pass1} onChange={(e) => setPassword1(e.target.value)} id="subject" placeholder="Password..." autocomplete="on" />
                                                    </fieldset>
                                                </div>
                                                <div class="col-lg-12">
                                                    <fieldset>
                                                        <input type="password" name="subject" value={pass2} onChange={(e) => setPassword2(e.target.value)} id="subject" placeholder="Repeat password..." autocomplete="on" />
                                                        <p style={{ color: 'red' }}>&nbsp;&nbsp;&nbsp;&nbsp;{error}</p>
                                                    </fieldset>
                                                </div>
                                                <div class="col-lg-12">
                                                    <fieldset>
                                                        <button onClick={register} class="orange-button">Sign up</button>
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

export default Register