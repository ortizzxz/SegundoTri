import { initializeApp } from "firebase/app";
import { getAuth } from "firebase/auth";
import { getFirestore } from "firebase/firestore";

const firebaseConfig = {
  apiKey: "AIzaSyAUPlJ0jSwSU1gXe9ljyMZ4kiZHyYMUTvo",
  authDomain: "pokeapp-3f1a6.firebaseapp.com",
  projectId: "pokeapp-3f1a6",
  storageBucket: "pokeapp-3f1a6.firebasestorage.app",
  messagingSenderId: "878414489246",
  appId: "1:878414489246:web:9bbbad921ac179eb9e3d8f"
};

const app = initializeApp(firebaseConfig);

export const auth = getAuth(app);
export const db = getFirestore(app);
export default app;