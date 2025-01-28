import { useState, useEffect } from 'react';
import { auth } from "../firebase";
import { Navigate } from 'react-router-dom';
import { onAuthStateChanged } from 'firebase/auth';

function PrivateRoute({ children }) {
    const [user, setUser] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const unsubscribe = onAuthStateChanged(auth, (user) => {
            setUser(user);
            setLoading(false);
        });

        return () => unsubscribe();
    }, []);

    if (loading) {
        return <>
            <div className="page-heading header-text">
                <div className="container">
                    <div className="row">
                        <div className="col-lg-12">
                            <h3>Loading page...</h3>
                            <span className="breadcrumb">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </>;
    }
    if (user) {
        return children;
    }

    return <Navigate to="/login" />;
}

export default PrivateRoute;