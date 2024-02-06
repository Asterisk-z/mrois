import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import axios from "axios";
import { errorHandler, successHandler } from "utils/Functions";
import queryGenerator from "utils/QueryGenerator";
const initialState = { all_institutions: null, all: null, list: null, latest_evidence: null, all_fields: null, list_extra: {}, status_list: null, transfer_list: null, user: null, total: null, error: "", loading: false };

export const loadInstitutionApplications = createAsyncThunk(
  "applicationProcess/loadInstitutionApplications",
  async () => {
    
    try {
      const { data } = await axios.get(`membership/application/all_institutions`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const loadMBGInstitutionApplications = createAsyncThunk(
  "applicationProcess/loadMBGInstitutionApplications",
  async () => {
    try {
      const { data } = await axios.get(`membership/application/mbg/institutions`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const loadFSDInstitutionApplications = createAsyncThunk(
  "applicationProcess/loadFSDInstitutionApplications",
  async () => {
    
    try {
      const { data } = await axios.get(`membership/application/fsd/institutions`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const loadMEGInstitutionApplications = createAsyncThunk(
  "applicationProcess/loadMEGInstitutionApplications",
  async () => {
    
    try {
      const { data } = await axios.get(`membership/application/meg/institutions`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const loadMEG2InstitutionApplications = createAsyncThunk(
  "applicationProcess/loadMEG2InstitutionApplications",
  async () => {
    try {
      const { data } = await axios.get(`membership/application/meg2/institutions`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const uploadPaymentProof = createAsyncThunk(
  "applicationProcess/uploadPaymentProof",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `membership/application/upload-payment-proof`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const uploadConcession = createAsyncThunk(
  "applicationProcess/uploadConcession",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `membership/application/mbg/upload-concession`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);


export const MEGReview = createAsyncThunk(
  "applicationProcess/MEGReview",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `membership/application/meg/review`,
        data: values,
      });
      return successHandler(data);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const MEG2Review = createAsyncThunk(
  "applicationProcess/MEG2Review",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `membership/application/meg2/review`,
        data: values,
      });
      return successHandler(data);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const MBGReview = createAsyncThunk(
  "applicationProcess/MBGReview",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `membership/application/mbg/review`,
        data: values,
      });
      return successHandler(data);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const MBGPaymentInformation = createAsyncThunk(
  "applicationProcess/MBGPaymentInformation",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `membership/application/mbg/payment-information`,
        data: values,
      });
      return successHandler(data);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const MBGPaymentEvidence = createAsyncThunk(
  "applicationProcess/MBGPaymentEvidence",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `membership/application/mbg/latest-payment-evidence`,
        data: values,
      });
      return successHandler(data);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const MBGPaymentDetails = createAsyncThunk(
  "applicationProcess/MBGPaymentDetails",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `membership/application/mbg/payment-details`,
        data: values,
      });
      return successHandler(data);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const MBGReviewSummary = createAsyncThunk(
  "applicationProcess/MBGReviewSummary",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `membership/application/mbg/fsd-review-summary`,
        data: values,
      });
      return successHandler(data);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const FSDPaymentInformation = createAsyncThunk(
  "applicationProcess/FSDPaymentInformation",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `membership/application/fsd/payment-information`,
        data: values,
      });
      return successHandler(data);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const FSDPaymentEvidence = createAsyncThunk(
  "applicationProcess/FSDPaymentEvidence",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `membership/application/fsd/latest-payment-evidence`,
        data: values,
      });
      return successHandler(data);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const FSDPaymentDetails = createAsyncThunk(
  "applicationProcess/FSDPaymentDetails",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `membership/application/fsd/payment-details`,
        data: values,
      });
      return successHandler(data);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const FSDReviewSummary = createAsyncThunk(
  "applicationProcess/FSDReviewSummary",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `membership/application/fsd/payment-review`,
        data: values,
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);



const applicationProcess = createSlice({
  name: "applicationProcess",
  initialState,
  reducers: {
    clearApplicationProcess: (state) => {
      state.customer = null;
      state.all_fields = null;
    },
    clearAllFields: (state) => {
      state.all_fields = null;
    },
  },
  extraReducers: (builder) => {

    // ====== builders for loadInstitutionApplications ======

    builder.addCase(loadInstitutionApplications.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadInstitutionApplications.fulfilled, (state, action) => {
        state.loading = false;
        // state.list = action.payload?.data?.data?.categories;
          
        state.all_institutions = JSON.stringify(action.payload?.data?.data);

    });

    builder.addCase(loadInstitutionApplications.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for loadMBGInstitutionApplications ======

    builder.addCase(loadMBGInstitutionApplications.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadMBGInstitutionApplications.fulfilled, (state, action) => {
        state.loading = false;
        // state.list = action.payload?.data?.data?.categories;
          
        state.all_institutions = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(loadMBGInstitutionApplications.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for loadMEG2InstitutionApplications ======

    builder.addCase(loadMEG2InstitutionApplications.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadMEG2InstitutionApplications.fulfilled, (state, action) => {
        state.loading = false;
        // state.list = action.payload?.data?.data?.categories;
          
        state.all_institutions = JSON.stringify(action.payload?.data?.data);

    });

    builder.addCase(loadMEG2InstitutionApplications.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for loadMEGInstitutionApplications ======

    builder.addCase(loadMEGInstitutionApplications.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadMEGInstitutionApplications.fulfilled, (state, action) => {
        state.loading = false;
        // state.list = action.payload?.data?.data?.categories;
          
        state.all_institutions = JSON.stringify(action.payload?.data?.data);

    });

    builder.addCase(loadMEGInstitutionApplications.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for loadFSDInstitutionApplications ======

    builder.addCase(loadFSDInstitutionApplications.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadFSDInstitutionApplications.fulfilled, (state, action) => {
        state.loading = false;
        // state.list = action.payload?.data?.data?.categories;
          
        state.all_institutions = JSON.stringify(action.payload?.data?.data);

    });

    builder.addCase(loadFSDInstitutionApplications.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });


    // ====== builders for uploadPaymentProof ======

    builder.addCase(uploadPaymentProof.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(uploadPaymentProof.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(uploadPaymentProof.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for uploadConcession ======

    builder.addCase(uploadConcession.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(uploadConcession.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(uploadConcession.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    // ====== builders for MEGReview ======

    builder.addCase(MEGReview.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(MEGReview.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(MEGReview.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    // ====== builders for MEG2Review ======

    builder.addCase(MEG2Review.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(MEG2Review.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(MEG2Review.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    // ====== builders for MBGReview ======

    builder.addCase(MBGReview.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(MBGReview.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(MBGReview.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    // ====== builders for MBGPaymentInformation ======

    builder.addCase(MBGPaymentInformation.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(MBGPaymentInformation.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(MBGPaymentInformation.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    // ====== builders for MBGPaymentEvidence ======

    builder.addCase(MBGPaymentEvidence.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(MBGPaymentEvidence.fulfilled, (state, action) => {
      state.loading = false;
      state.latest_evidence = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(MBGPaymentEvidence.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    // ====== builders for MBGPaymentDetails ======

    builder.addCase(MBGPaymentDetails.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(MBGPaymentDetails.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(MBGPaymentDetails.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    // ====== builders for MBGReviewSummary ======

    builder.addCase(MBGReviewSummary.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(MBGReviewSummary.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(MBGReviewSummary.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    // ====== builders for FSDPaymentInformation ======

    builder.addCase(FSDPaymentInformation.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(FSDPaymentInformation.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(FSDPaymentInformation.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    // ====== builders for FSDPaymentEvidence ======

    builder.addCase(FSDPaymentEvidence.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(FSDPaymentEvidence.fulfilled, (state, action) => {
      state.loading = false;
      state.latest_evidence = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(FSDPaymentEvidence.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    // ====== builders for FSDPaymentDetails ======

    builder.addCase(FSDPaymentDetails.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(FSDPaymentDetails.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(FSDPaymentDetails.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    // ====== builders for FSDReviewSummary ======

    builder.addCase(FSDReviewSummary.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(FSDReviewSummary.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(FSDReviewSummary.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    
  },
});

export default applicationProcess.reducer;
export const { clearApplicationProcess } = applicationProcess.actions;