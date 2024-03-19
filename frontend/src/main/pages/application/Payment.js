import React, { useState, useRef, useEffect, forwardRef } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate, useParams } from "react-router-dom";
import { useForm } from "react-hook-form";
import Head from "layout/head/Head";
import Content from "layout/content/Content";
import { BlockContent, BlockTitle, Icon } from "components/Component";
import { Steps, Step } from "react-step-builder";
import { Col, Row, Button, Dropdown, UncontrolledDropdown, DropdownToggle, DropdownMenu, DropdownItem, Badge,  Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner, Label, CardBody, CardTitle, CardText } from "reactstrap";
import { HeaderLogo } from "pages/components/HeaderLogo";
import DatePicker from "react-datepicker";
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';
import { loadApplication, fetchApplication } from "redux/stores/membership/applicationStore";
import { loadInvoiceDownload, UploadAgreement, uploadPaymentProof } from "redux/stores/membership/applicationProcessStore";
import moment from 'moment';
import Swal from "sweetalert2";







const Payment = () => {
    


  return <>
    <Head title="Payment" />
    <HeaderLogo />

  </>;
};
// type="submit"  
export default Payment;

