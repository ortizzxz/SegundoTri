import { useState } from 'react'
import 'bootstrap/dist/css/bootstrap.min.css';

import Header from './components/Header'
import Home from './components/Home'
import Pokemons from './components/Pokemons'
import Login from './components/Login'
import Register from './components/Register'
import Detail from './components/Detail'
// import Game from './components/Game'
import Error from './components/Error'
import Footer from './components/Footer'
import { Outlet } from 'react-router-dom'
import PrivateRoute from './components/PrivateRoute'

import {
  createBrowserRouter,
  RouterProvider,
} from "react-router-dom";

const router = createBrowserRouter([
  {
    element: (
      <>
        <Header></Header>
        <Outlet></Outlet>
        <Footer></Footer>
      </>
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
      // {
      //   path: "game",
      //   element: (
      //     <>
      //       <PrivateRoute>
      //         <Game></Game>
      //       </PrivateRoute>

      //     </>
      //   ),
      // },
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