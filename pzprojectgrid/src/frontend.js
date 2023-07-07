import { TextControl, DatePicker } from "@wordpress/components";
import Button from "@mui/material/Button";
import {
  DataGrid,
  GridRowsProp,
  GridColDef,
  GridToolbar,
} from "@mui/x-data-grid";
import Box from "@mui/material/Box";
import Typography from "@mui/material/Typography";
import Modal from "@mui/material/Modal";

const xdiv = document.querySelector(".pz-target-div");

const url = "http://suchthings.local/wp-json/pz/v1/project";
let response = await fetch(url);
let json = await response.text();
let rows = JSON.parse(json);
// console.log(rows);

const columns = [
  { field: "id", headerName: "ID", width: 20 },
  { field: "project_name", headerName: "Project ", width: 150 },
  { field: "project_status", headerName: "Status", width: 150 },
  { field: "project_lead", headerName: "Lead", width: 150 },
  { field: "kickoff_date", headerName: "Kickoff", width: 150 },
  { field: "due_date", headerName: "Due Date", width: 150 },
];

ReactDOM.render(<MyComponent />, xdiv);

function MyComponent() {
  function handleEvent(
    params, // GridRowParams
    event, // MuiEvent<React.MouseEvent<HTMLElement>>
    details // GridCallbackDetails
  ) {
    console.log(params);
    alert(params.id);
  }

  return (
    <div>
      <div style={{ height: 800, width: "100%" }}>
        <DataGrid
          rows={rows}
          columns={columns}
          rowHeight={33}
          slots={{ toolbar: GridToolbar }}
          onRowDoubleClick={handleEvent}
        />
      </div>
    </div>
  );
}
