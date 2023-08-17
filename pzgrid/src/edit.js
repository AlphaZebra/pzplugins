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
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { TextControl, PanelBody } from "@wordpress/components";

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
  const imageURL =
    window.location.origin +
    "/wp-content/plugins/pzprojectform/includes/assets/edit-side-image.png";

  return (
    <div {...useBlockProps()}>
      <InspectorControls>
        <PanelBody title="When Adding/Editing">
          <TextControl
            label="URL for Person Add form"
            value={attributes.addURL}
            onChange={(value) => setAttributes({ addURL: value })}
          />
          <TextControl
            label="URL for Person Edit form"
            value={attributes.editURL}
            onChange={(value) => setAttributes({ editURL: value })}
          />
        </PanelBody>
        <PanelBody title="Set type of person">
          <TextControl
            label="set tag such as staff or customer"
            value={attributes.tag}
            onChange={(value) => setAttributes({ tag: value })}
          />
        </PanelBody>
      </InspectorControls>
      <table>
        <tr>
          <td>
            <img src={imageURL}></img>
          </td>
          <td>
            <h4>PZ Person Grid</h4>
          </td>
        </tr>
      </table>
    </div>
  );
}
