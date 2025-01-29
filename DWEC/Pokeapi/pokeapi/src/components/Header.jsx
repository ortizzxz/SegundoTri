import { Link, useNavigate } from "react-router-dom";
import { auth } from "../firebase";
import { signOut } from "firebase/auth";
import { onAuthStateChanged } from "firebase/auth";
import { useState, useEffect } from "react";

function Header() {
  const navigate = useNavigate();

  let [nav, setNav] = useState(
    <ul className="nav">
      <li>
        <Link to="/">Home</Link>
      </li>
      <li>
        <Link to="/pokemons">Pokemons</Link>
      </li>
      <li>
        <Link to="/login">Sign In</Link>
      </li>
    </ul>
  );

  useEffect(() => {
    onAuthStateChanged(auth, (user) => {
      if (user) {
        setNav(
          <ul className="nav justify-content-end">
            <li className="nav-item">
              <Link className="nav-link" to="/">
                Home
              </Link>
            </li>
            <li className="nav-item">
              <Link className="nav-link" to="/pokemons">
                Pokemons
              </Link>
            </li>
            <li className="nav-item">
              <Link className="nav-link" to="/game">
                Game
              </Link>
            </li>
            <li className="nav-item">
              <button className="btn btn-link nav-link" onClick={logout}>
                Log Out
              </button>
            </li>
            <li className="nav-item">
              <span className="nav-link">{user.displayName}</span>
            </li>
          </ul>
        );
      } else {
        setNav(
          <ul className="nav justify-content-end">
            <li className="nav-item">
              <Link className="nav-link" to="/">
                Home
              </Link>
            </li>
            <li className="nav-item">
              <Link className="nav-link" to="/pokemons">
                Pokemons
              </Link>
            </li>
            <li className="nav-item">
              <Link className="nav-link" to="/login">
                Sign In
              </Link>
            </li>
          </ul>
        );
      }
    });
  }, []);

  function logout() {
    signOut(auth)
      .then(() => {
        navigate("/login"); 
      })
      .catch((error) => {
        console.error("Error signing out:", error);
      });
  }

  return (
    <>
      <header className="header-area header-sticky">
        <div className="container">
          <div className="row">
            <div className="col-12">
              <nav className="navbar navbar-expand-lg navbar-light">
                <a className="navbar-brand" href="/">
                  <img
                    src="./src/assets/images/logo.png"
                    alt=""
                    style={{ width: "158px" }}
                  />
                </a>
                {nav}
              </nav>
            </div>
          </div>
        </div>
      </header>
    </>
  );
}

export default Header;
