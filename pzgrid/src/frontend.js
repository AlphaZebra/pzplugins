import { TextControl, DatePicker } from "@wordpress/components";
import Button from "@mui/material/Button";
import Box from "@mui/material/Box";
import AddIcon from "@mui/icons-material/Add";
import EditIcon from "@mui/icons-material/Edit";
import DeleteIcon from "@mui/icons-material/DeleteOutlined";
import {
  DataGridPro,
  GridToolbarContainer,
  GridToolbarColumnsButton,
  GridToolbarFilterButton,
  GridToolbarExport,
  GridToolbarDensitySelector,
} from "@mui/x-data-grid-pro";
import { LicenseInfo } from "@mui/x-license-pro";
LicenseInfo.setLicenseKey(
  "94af6ed0a88af0eb477e40d45142c51eTz03MjUyMCxFPTE3MjMzMzc0OTYwMDAsUz1wcm8sTE09c3Vic2NyaXB0aW9uLEtWPTI="
);

const xdiv = document.querySelector(".pz-target-div");
const attributes = JSON.parse(xdiv.innerText);
if (attributes.onlyExpired == true) {
  attributes.queryTail = "WHERE expires <= CAST( now() as date)";
}
const url =
  attributes.siteURL + "/wp-json/pz/v1/person/?tail=" + attributes.queryTail;
console.log(url);

let response = await fetch(url);
let json = await response.text();
let rows = JSON.parse(json);
console.log(rows);

function IntEditToolbar() {
  const handleClick = () => {
    const url = attributes.addURL + "?prj=" + attributes.prj;

    //   const id = randomId();
    //   setRows((oldRows) => [...oldRows, { id, name: '', age: '', isNew: true }]);
    //   setRowModesModel((oldModel) => ({
    //     ...oldModel,
    //     [id]: { mode: GridRowModes.Edit, fieldToFocus: 'name' },
    //   }));
    window.location.href = url;
  };

  return (
    <GridToolbarContainer>
      <Button color="primary" startIcon={<AddIcon />} onClick={handleClick}>
        Add interaction
      </Button>
      <GridToolbarColumnsButton />
      <GridToolbarFilterButton />
      <GridToolbarDensitySelector />
    </GridToolbarContainer>
  );
}

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
    window.location.href = "/interactions/?per=" + params.id;
  }

  return (
    <div>
      <div style={{ height: 800, width: "100%" }}>
        <DataGridPro
          rows={rows}
          columns={columns}
          rowHeight={33}
          slots={{ toolbar: IntEditToolbar }}
          onRowDoubleClick={handleEvent}
        />
      </div>
    </div>
  );
}
