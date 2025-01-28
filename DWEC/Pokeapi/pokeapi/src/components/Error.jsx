
import { Link, useEffect } from "react";
import { useState } from "react";
import { useParams } from "react-router-dom";

function Error() {

    return (
        <>
            <div className="page-heading header-text">
                <div className="container">
                    <div className="row">
                        <div className="col-lg-12">
                            <h3>404</h3>
                            <span className="breadcrumb">Page not found</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section categories">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <div class="section-heading">
                                <h6>Oops!</h6>
                                <h2>The page you're looking for couldn't be found</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </>
    )
}

export default Error