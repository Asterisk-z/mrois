import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadCCOArCompetency } from "redux/stores/competency/competencyStore";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import ApproveCompetencyTable from './Tables/ApproveCompetencyTable'
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';



const ApproveCompetency = ({ drawer }) => {

    const authUser = useUser();
    const authUserUpdate = useUserUpdate();

    if (authUser.is_position_cco()) {
        const [counter, setCounter] = useState(false);
        const dispatch = useDispatch();
        const [parentState, setParentState] = useState('Initial state');

        const competencies = useSelector((state) => state?.competency?.list_approval) || null;

        useEffect(() => {
            dispatch(loadCCOArCompetency());
        }, [dispatch, parentState]);


        const $competencies = competencies ? JSON.parse(competencies) : null;

        const updateParentState = (newState) => {
            setParentState(newState);
        };


        return (
            <React.Fragment>
                <Head title="Approve Competency"></Head>
                <Content>
                    <BlockHead size="sm">
                        <BlockBetween>
                            <BlockHeadContent>
                                <BlockTitle page tag="h3">
                                    Approve Competency
                                </BlockTitle>
                            </BlockHeadContent>
                        </BlockBetween>
                    </BlockHead>
                    <Block size="lg">
                        <Card className="card-bordered card-preview">
                            <Content>


                                <Block size="xl">
                                    <BlockHead>
                                        <BlockHeadContent>
                                            {/* <BlockTitle tag="h4"></BlockTitle> */}
                                            {/* <p>{competencies}</p> */}
                                        </BlockHeadContent>
                                    </BlockHead>

                                    <PreviewCard>
                                        {$competencies && <ApproveCompetencyTable data={$competencies} updateParent={updateParentState} expandableRows pagination actions />}
                                    </PreviewCard>
                                </Block>


                            </Content>
                        </Card>
                    </Block>
                </Content>
            </React.Fragment>
        );
    } else {

        return (
            <React.Fragment>
                <Head title="Sanction"></Head>
                <Content>
                    <BlockHead size="sm">
                        <BlockBetween>
                            <BlockHeadContent>
                                <BlockTitle page tag="h3">
                                    You are not authorised to access this module
                                </BlockTitle>
                            </BlockHeadContent>
                        </BlockBetween>
                    </BlockHead>
                </Content>
            </React.Fragment>);
    }

};
export default ApproveCompetency;
