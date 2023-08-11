/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useState } from "@wordpress/element";
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
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */

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
  // const { backgroundColor } = attributes;
  const [values, setValues] = useState({
    top: "50px",
    left: "10%",
    right: "10%",
    bottom: "50px",
  });

  const imageURL =
    window.location.origin +
    "/wp-content/plugins/pzprojectgrid/includes/assets/project-list.png";

  return (
    <div {...useBlockProps()}>
      <InspectorControls>
        <PanelBody title="Spacing">
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
        </PanelBody>

        <PanelBody title="When Adding/Editing">
          <TextControl
            label="URL for Project Add form"
            value={attributes.addURL}
            onChange={(value) => setAttributes({ addURL: value })}
          />
          <TextControl
            label="URL for Project Edit form"
            value={attributes.editURL}
            onChange={(value) => setAttributes({ editURL: value })}
          />
          <TextControl
            label="URL for Task Lists"
            value={attributes.taskListURL}
            onChange={(value) => setAttributes({ taskListURL: value })}
          />
          <TextControl
            label="Advanced internal app name"
            value={attributes.appName}
            onChange={(value) => setAttributes({ appName: value })}
          />
        </PanelBody>
      </InspectorControls>
      <img src={imageURL}></img>
    </div>
  );
}
