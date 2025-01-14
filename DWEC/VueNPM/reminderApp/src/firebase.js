import { initializeApp } from "firebase/app";
import { getFirestore, collection } from "firebase/firestore";

const firebaseConfig = {
  apiKey: "AIzaSyDhIRMY2nV5G-a0k_zi16eLQhmJ350O2_E",
  authDomain: "notesapp-43b16.firebaseapp.com",
  projectId: "notesapp-43b16",
  storageBucket: "notesapp-43b16.firebasestorage.app",
  messagingSenderId: "835242856860",
  appId: "1:835242856860:web:7a9bde9f64d16ba33d7859",
};

const firebaseApp = initializeApp(firebaseConfig);

const db = getFirestore(firebaseApp);

export default firebaseApp; 
export const allNotes = collection(db, "notesApp");
