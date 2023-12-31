import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import axios from "axios";
import { errorHandler, successHandler } from "utils/Functions";
import queryGenerator from "utils/QueryGenerator";
const initialState = { all: null, list: null, all_fields: null, single_ar: null, status_list: null, transfer_list: null, user: null, total: null, error: "", loading: false };

export const loadPageFields = createAsyncThunk(
  "application/loadPageFields",
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
  "application/loadFieldOption",
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

export const uploadField = createAsyncThunk(
  "application/uploadField",
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


const applicationStore = createSlice({
  name: "application",
  initialState,
  reducers: {
    clearArUser: (state) => {
      state.customer = null;
    },
  },
  extraReducers: (builder) => {

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
  
    
  },
});

export default applicationStore.reducer;
export const { clearArUser } = applicationStore.actions;