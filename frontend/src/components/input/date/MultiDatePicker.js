import React, { useState } from "react";
import DatePicker from "react-multi-date-picker"
import DatePanel from "react-multi-date-picker/plugins/date_panel"

const MultiDatePicker = ({ id, nameAttr, changeAction }) => {
  
  const [values, setValues] = useState([])
  const [inputName, setInputName] = useState(nameAttr)
  // const [minDate, setMinDate] = useState(new Date(min))
  // const [maxDate, setMaxDate] = useState(new Date(max))

        // minDate={minDate}
        // maxDate={maxDate}
  return (
    <React.Fragment>
      <DatePicker inputClass="form-control" containerClassName="custom-container"
        multiple
        value={values} 
        name={inputName}
        id={id}
        onClose={(value) => changeAction(values.map((val) => `${val.year}-${val.month.number}-${val.day}`))}
        onChange={setValues}
          plugins={[
          <DatePanel />
          ]}
      />
    </React.Fragment>
  );
};

export default MultiDatePicker;
