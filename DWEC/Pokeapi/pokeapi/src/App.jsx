import Header from './components/Header'
import Home from './components/Home'
import Pokemons from './components/Pokemons'
import Login from './components/Login'
import Register from './components/Register'
import Detail from './components/Detail'
import Game from './components/Game'
import Error from './components/Error'
import Footer from './components/Footer'
import { Outlet } from 'react-router-dom'
import PrivateRoute from './components/PrivateRoute'
import { useEffect } from 'react';
import { getRedirectResult } from "firebase/auth";
import { auth } from './firebase';
import { useNavigate } from 'react-router-dom';
import "bootstrap-icons/font/bootstrap-icons.css";
import 'bootstrap/dist/css/bootstrap.min.css';
import "bootstrap-icons/font/bootstrap-icons.css";

import {
  createBrowserRouter,
  RouterProvider,
} from "react-router-dom";

function RedirectHandler({ children }) {
  const navigate = useNavigate();

  useEffect(() => {
    console.log("Checking redirect result...");

    getRedirectResult(auth)
      .then((result) => {
        console.log("Redirect result received:", result);
        
        if (result?.user) {
          console.log("User signed in via redirect:", result.user);
          navigate("/game");
        } else {
          console.log("No user found in redirect result.");
        }
      })
      .catch((error) => {
        console.error("Redirect Sign-In Error:", error);
      });
  }, [navigate]);

  return children;
}




const router = createBrowserRouter([
  {
    element: (
      <RedirectHandler>
      <>
        <Header></Header>
        <Outlet></Outlet>
        <Footer></Footer>
      </>
      </RedirectHandler>
    ),

    children: [
      {
        path: "/",
        element: (
          <>
            <Home></Home>
          </>
        ),
        errorElement: <>
          <Error></Error>
        </>
      },
      {
        path: "pokemons",
        element: (
          <>
            <Pokemons></Pokemons>
          </>
        ),
      },
      {
        path: "login",
        element: (
          <>
            <Login></Login>
          </>
        ),
      },
      {
        path: "detail/:id",
        element: (
          <>
            <Detail></Detail>
          </>
        ),
      },
      {
        path: "register",
        element: (
          <>
            <Register></Register>
          </>
        ),
      },
      {
        path: "game",
        element: (
          <>
            <PrivateRoute>
              <Game></Game>
            </PrivateRoute>

          </>
        ),
      },
      {
        path: "*",
        element:
          <Error></Error>
      }
    ]
  }

]);

function App() {

  return (
    <>
      <RouterProvider router={router} />
    </>
  )
}

export default App