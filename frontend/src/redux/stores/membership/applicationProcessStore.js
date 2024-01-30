import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import axios from "axios";
import { errorHandler, successHandler } from "utils/Functions";
import queryGenerator from "utils/QueryGenerator";
const initialState = { all_institutions: null, all: null, list: null, all_fields: null, list_extra: {}, status_list: null, transfer_list: null, user: null, total: null, error: "", loading: false };

export const loadInstitutionApplications = createAsyncThunk(
  "applicationProcess/loadInstitutionApplications",
  async () => {
    
    try {
      const { data } = await axios.get(`membership/application/mbg/institutions`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
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
      return successHandler(data);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);










export const loadPageFields = createAsyncThunk(
  "applicationProcess/loadPageFields",
  async (values) => {
    const query = queryGenerator(values);
    try {
      const { data } = await axios.get(`membership/application/fields?${query}`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const loadFieldOption = createAsyncThunk(
  "applicationProcess/loadFieldOption",
  async (values) => {
    const query = queryGenerator(values);
    try {
      const { data } = await axios.get(`membership/application/field/option?${query}`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const loadExtra = createAsyncThunk(
  "applicationProcess/loadExtra",
  async (values) => {
    const query = queryGenerator(values);
    try {
      const { data } = await axios.get(`membership/application/extra?${query}`);
      return successHandler(data);
    } catch (error) {
      return errorHandler(error);
    }
  }
);

export const uploadField = createAsyncThunk(
  "applicationProcess/uploadField",
  async (values) => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `membership/application/upload`,
        data: values,
      });
      return successHandler(data);
    } catch (error) {
      return errorHandler(error, true);
    }
  }
);


export const completeApplication = createAsyncThunk(
  "applicationProcess/completeApplication",
  async () => {
    try {
      const { data } = await axios({
        method: "post",
        headers: {
          Accept: "application/json",
          // "Content-Type": "application/json;charset=UTF-8",
          "Content-Type": "multipart/form-data",
        },
        url: `membership/application/complete`,
        // data: values,
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
  


















    // ====== builders for loadFieldOption ======

    builder.addCase(loadFieldOption.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadFieldOption.fulfilled, (state, action) => {
        state.loading = false;
        // state.list = action.payload?.data?.data?.categories;
          
        if (!Array.isArray(state.all)) {
          state.all = [];
      }
      
      const all = [...state.all];
      
        all.push(action.payload?.data.data);
        state.all = all;

    });

    builder.addCase(loadFieldOption.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
    
    // ====== builders for loadExtra ======

    builder.addCase(loadExtra.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadExtra.fulfilled, (state, action) => {
        state.loading = false;
        // state.list = action.payload?.data?.data?.categories;
          
        if (!Array.isArray(state.list_extra)) {
          state.list_extra = {};
      }
      
      const list_extra = state.list_extra;
      const data = { ...list_extra, [action.payload?.data.data.name]: action.payload?.data.data };
      state.list_extra = data;

    });

    builder.addCase(loadExtra.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });

    
    // ====== builders for loadPageFields ======

    builder.addCase(loadPageFields.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(loadPageFields.fulfilled, (state, action) => {
        state.loading = false;
        // state.list = action.payload?.data?.data?.categories;
        // state.list = JSON.stringify(action.payload?.data?.data);
        
        // if (!Array.isArray(state.all_fields)) {
          state.all_fields = [];
      // }
      
      // const all_fields = [...state.all_fields];
      const all_fields = [];
      // console.log(new Date())
        all_fields.push(...action.payload?.data.data);
        state.all_fields = all_fields;
    });

    builder.addCase(loadPageFields.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });


    // ====== builders for uploadField ======

    builder.addCase(uploadField.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(uploadField.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(uploadField.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
  

    // ====== builders for completeApplication ======

    builder.addCase(completeApplication.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(completeApplication.fulfilled, (state, action) => {
      state.loading = false;
    });

    builder.addCase(completeApplication.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload.message;
    });
  
    
  },
});

export default applicationProcess.reducer;
export const { clearApplicationProcess } = applicationProcess.actions;