/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

import { useState } from "@wordpress/element"; // WordPress React wrapper
import {
  useBlockProps,
  InspectorControls,
  useSetting,
} from "@wordpress/block-editor";
import { __experimentalBoxControl as BoxControl } from "@wordpress/components";
import {
  PanelBody,
  TextControl,
  CheckboxControl,
  ColorPalette,
} from "@wordpress/components";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit(props) {
  const { attributes, setAttributes } = props;
  const { backgroundColor } = attributes;
  const [values, setValues] = useState({
    top: "50px",
    left: "10%",
    right: "10%",
    bottom: "50px",
  });

  const imageURL =
    window.location.origin +
    "/wp-content/plugins/pzlinkgrid/includes/assets/edit-side-image.png";

  return (
    <div {...useBlockProps()}>
      <InspectorControls>
        {/* <PanelBody title="Spacing">
          <BoxControl
            label="Margin"
            values={values}
            onChange={(nextValues) => setValues(nextValues)}
          />
          <CheckboxControl
            label="Edit Current Person?"
            checked={attributes.isEdit}
            onChange={(value) => setAttributes({ isEdit: value })}
          />
          <p>Input background</p>
          <ColorPalette
            value={backgroundColor}
            colors={useSetting("color.palette")}
            onChange={(value) => setAttributes({ backgroundColor: value })}
          />
        </PanelBody> */}

        <PanelBody title="When Adding/Editing">
          <TextControl
            label="URL for Link Add form"
            value={attributes.addURL}
            onChange={(value) => setAttributes({ addURL: value })}
          />
          <TextControl
            label="URL for Link Edit form"
            value={attributes.editURL}
            onChange={(value) => setAttributes({ editURL: value })}
          />
          <TextControl
            label="Category (optional)"
            value={attributes.category}
            onChange={(value) => setAttributes({ category: value })}
          />
          <CheckboxControl
            label="Show menu?"
            checked={attributes.isMenu}
            onChange={(value) => setAttributes({ isMenu: value })}
          />
          <CheckboxControl
            label="Show column headers?"
            checked={attributes.isColumnHeaders}
            onChange={(value) => setAttributes({ isColumnHeaders: value })}
          />
        </PanelBody>
      </InspectorControls>
      <table>
        <tr>
          <td>
            <img src={imageURL}></img>
          </td>
          <td>
            <h4>PZ Link Grid</h4>
          </td>
        </tr>
      </table>
    </div>
  );
}
