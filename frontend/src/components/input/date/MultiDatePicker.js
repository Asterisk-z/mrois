import moment from "moment";
import React, { useState } from "react";
import DatePicker from "react-multi-date-picker"
import DatePanel from "react-multi-date-picker/plugins/date_panel"

const MultiDatePicker = ({ id, nameAttr, changeAction, max, properties }) => {

  const [values, setValues] = useState([])
  const [inputName, setInputName] = useState(nameAttr)
  const [min, setMin] = useState(new Date())
  // const [maxDate, setMaxDate] = useState(new Date(max))
  // minDate={minDate}
  // maxDate={maxDate}
  // console.log(values)
  return (
    <React.Fragment>
      <DatePicker inputClass="form-control" containerClassName="custom-container"
        multiple
        value={values}
        format="DD/MM/YYYY"
        name={inputName}
        id={id}
        minDate={min}
        maxDate={max ? max : moment().endOf("year").format('L')}
        {...properties}
        onClose={(value) => changeAction(values.map((val) => `${val.year}-${val.month.number.toString().padStart(2, '0')}-${val.day}`))}
        onChange={setValues}
        plugins={[
          <DatePanel />
        ]}
      />
    </React.Fragment>
  );
};

export default MultiDatePicker;
