import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import axios from "axios";
import { errorHandler, successHandler } from "../../../utils/Functions";

const initialState = {
  list: null,
  error: "",
  view_all: null,
  active_list: null,
  active: null,
  loading: false,
};

export const loadActiveGuide = createAsyncThunk(
  "applicant-guide/loadActiveGuide",
  async (arg) => {
    try {
      const { data } = await axios.get(`applicant-guide/current`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const loadApplicantGuide = createAsyncThunk(
  "applicant-guide/loadApplicantGuide",
  async (arg) => {
    try {
      const { data } = await axios.get(`meg/applicant-guides/list-all`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const createApplicantGuide = createAsyncThunk(
  "applicant-guide/createApplicantGuide",
  async (values) => {
    try {
      const { data } = await axios.post(`meg/applicant-guides/create`, values, {
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const updateApplicantGuide = createAsyncThunk(
  "applicant-guide/updateApplicantGuide",
  async (values) => {
    const id = values.id;
    try {
      const { data } = await axios.post(`meg/applicant-guides/update/${id}`, values, {
        headers: {
          Accept: "application/json",
          "Content-Type": "multipart/form-data",
        },
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

export const updateApplicantGuideStatus = createAsyncThunk(
  "applicant-guide/updateApplicantGuideStatus",
  async (values) => {
    const id = values.get('id');
    try {
      const { data } = await axios.post(`meg/applicant-guides/update-status/${id}`, values, {
        headers: {
          Accept: "application/json",
          "Content-Type": "multipart/form-data",
        },
      });
      return successHandler(data, data.message);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);

const applicantGuideStore = createSlice({
  name: "applicant_guide",
  initialState,
  reducers: {
    clearApplicantGuide: (state) => {
      state.list = null;
    },
  },
  extraReducers: (builder) => {
    // builder.addCase(loadFeesAndDues.fulfilled, (state, action) => {
    //   state.list_all = JSON.stringify(action.payload?.data?.data);
    // });

    builder.addCase(loadApplicantGuide.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadApplicantGuide.fulfilled, (state, action) => {
      state.loading = false;
      state.view_all = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(loadApplicantGuide.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    builder.addCase(loadActiveGuide.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadActiveGuide.fulfilled, (state, action) => {
      state.loading = false;
      state.active = JSON.stringify(action.payload?.data?.data);
    });

    builder.addCase(loadActiveGuide.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    builder.addCase(createApplicantGuide.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(createApplicantGuide.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(createApplicantGuide.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    builder.addCase(updateApplicantGuide.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(updateApplicantGuide.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(updateApplicantGuide.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    builder.addCase(updateApplicantGuideStatus.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(updateApplicantGuideStatus.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(updateApplicantGuideStatus.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
  },
});

export default applicantGuideStore.reducer;
export const { clearApplicantGuide } = applicantGuideStore.actions;
