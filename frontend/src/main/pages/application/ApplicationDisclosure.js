import React, { useState, useRef, useEffect, forwardRef } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate, useParams } from "react-router-dom";
import { useForm } from "react-hook-form";
import Head from "layout/head/Head";
import Content from "layout/content/Content";
import { BlockContent, BlockTitle, Icon } from "components/Component";
import { Steps, Step } from "react-step-builder";
import { Row, Col, Button, Input } from "reactstrap";
import { HeaderLogo } from "pages/components/HeaderLogo";
import DatePicker from "react-datepicker";
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';
import { loadPageFields, fetchApplication, completeApplication, fetchInitialApplication, retainField } from "redux/stores/membership/applicationStore";
import { UpdateDisclosure } from "redux/stores/membership/applicationProcessStore";
import moment from 'moment';
import Swal from "sweetalert2";



const Header = (props) => {
    return (
        <div className="steps clearfix">
            <ul>
            </ul>
        </div>
    );
};



const config = {
    before: Header,
};

const Form = () => {


    const authUser = useUser();
    const authUserUpdate = useUserUpdate();

    const styles = {
        color: {
            marginBottom: "10px",
        },
        scroll: {
            overFlow: "scroll",
        },
        card: {
            backgroundColor: "#fff",
            margin: "50px 30px",
            padding: "20px"
        }

    }
    const dispatch = useDispatch();
    const navigate = useNavigate();
    const { application_uuid } = useParams();

    const [parentState, setParentState] = useState('Initial state');
    const application_details = useSelector((state) => state?.application?.application_details) || null;
    const initial_application = useSelector((state) => state?.application?.initial_application) || null;

    useEffect(() => {
        if (application_uuid) {
            dispatch(fetchApplication({ "application_uuid": application_uuid }));
        }
    }, [dispatch, parentState]);

    const $application_details = application_details ? JSON.parse(application_details) : null;

    useEffect(() => {
        if (!$application_details?.disclosure_stage) {
            dispatch(fetchInitialApplication({ "application_uuid": application_uuid }));
        }
    }, []);


    const $initial_application = initial_application ? JSON.parse(initial_application) : null;

    const ApplicantInformation = (props) => {


        const authUser = useUser();
        const authUserUpdate = useUserUpdate();

        const dispatch = useDispatch();



        const onInputChange = async (event, values) => {

            event.target.className = "btn btn-success";
            event.target.innerHTML = "Moved";
            
            const postValues = new Object();
            postValues.field_name = values.field_name;
            postValues.field_value = values.field_value;
            postValues.field_type = values.field_type;
            postValues.application_id = $application_details?.id;
            postValues.category_id = $application_details?.membership_category?.id;

            try {

                const resp = await dispatch(retainField(postValues));

                // if (resp.payload?.message == "success") {
                //     console.log('getere')
                //     setParentState(Math.random())
                // } else {

                // }

            } catch (error) {

            }
        };

        const onSubmit = () => {

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to continue application!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes!",
                cancelButtonText: "No",
            }).then((result) => {

                if (result.isConfirmed) {

                    submitApplication()

                }
            });

        };


        const submitApplication = async () => {
            try {


                const postValues = new Object();
                postValues.application_id = $application_details?.id;
                postValues.status = 'accept';
                const resp = dispatch(UpdateDisclosure(postValues));

                // if (resp.payload?.message == "success") {

                    navigate(`${process.env.PUBLIC_URL}/application/${$application_details?.uuid}`)
                // } else {
                //     navigate(`${process.env.PUBLIC_URL}/dashboard`)
                // }

            } catch (error) {

            }
        };

        const submitForm = (data) => {

        };

        // console.log(authUser.user_data.institution);

        return (

                <div>


                <table className="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col" className="width-30">Value</th>
                            <th scope="col" >Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {/* {$user_application} */}
                        {$initial_application?.application_requirements && $initial_application?.application_requirements?.map((initial_application_item, index) => (
                            <tr key={index}>
                                <th scope="row">{++index}</th>
                                <td>{initial_application_item.field.description}</td>
                                <td>
                                    {initial_application_item.uploaded_file != null ? <>
                                        <a className="btn btn-primary" href={initial_application_item.file_path} target="_blank">View File </a>
                                    </> : <>
                                        {initial_application_item.uploaded_field}
                                    </>}
                                </td>
                                <td>
                                    <Button className="btn btn-secondary"
                                        title="By clicking this button, you confirm acceptance of the existing document" 
                                        onClick={(e) => onInputChange(event, {
                                            'field_name': initial_application_item?.field?.name,
                                            'application_id': $application_details?.id,
                                            "category_id": $application_details?.membership_category?.id,
                                            "field_value": (initial_application_item?.uploaded_field ? initial_application_item?.uploaded_field : initial_application_item?.uploaded_file),
                                            "field_type": initial_application_item?.field?.type
                                        })} >
                                        Move</Button>
                                </td>
                            </tr>

                        ))}
                    </tbody>
                </table>

                    <div>
                        <button className="btn btn-primary" onClick={onSubmit}>Continue Application</button>
                    </div>
                
                </div>

        );
    };


    return <>
        <Head title="Disclosure" />
        <HeaderLogo />

        <Content>
            <Content>
                <div className="">
                    <div style={{ 'margin': '0px 10px !important' }}>
                        <div style={styles.card}>
                            <div style={styles.color}>
                                <Button color="primary" onClick={(e) => navigate(`${process.env.PUBLIC_URL}/application/${$application_details?.uuid}`)}>
                                    <span>Back</span>
                                </Button>
                                {$application_details && <h3>{`${$application_details.membership_category.name} Application`} </h3>}
                                <p>Move data to new membership category</p>
                            </div>
                            <div className="nk-wizard nk-wizard-simple is-alter wizard clearfix">
                                <Steps config={config}>
                                    <Step component={ApplicantInformation} />
                                </Steps>
                            </div>
                        </div>
                    </div>
                </div>
            </Content>
        </Content>

    </>;
};
// type="submit"
export default Form;

