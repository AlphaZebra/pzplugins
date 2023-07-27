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

const url = "http://suchthings.local/wp-json/pz/v1/person";
let response = await fetch(url);
let json = await response.text();
let rows = JSON.parse(json);
console.log(rows);

// const rows = [
// 	{ id: 1, col1: "Hello", col2: "World" },
// 	{ id: 2, col1: "DataGridPro", col2: "is Awesome" },
// 	{ id: 3, col1: "MUI", col2: "is Amazing" },
// ];

const columns = [
  { field: "id", headerName: "ID", width: 20 },
  { field: "firstname", headerName: "First ", width: 150 },
  { field: "lastname", headerName: "Last", width: 150 },
  { field: "title", headerName: "Title", width: 150 },
  { field: "company", headerName: "Company", width: 150 },
  { field: "email", headerName: "Email", width: 150 },
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
          rowReordering
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
