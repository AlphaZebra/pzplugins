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

import {
	PanelBody,
	RadioControl,
	TextControl,
	CheckboxControl,
} from "@wordpress/components";
import { useState } from "@wordpress/element";

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import "./editor.scss";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
	return (
		<div {...useBlockProps()}>
			<InspectorControls>
				<PanelBody title="Access">
					<CheckboxControl
						label="Restrict to logged-in users?"
						checked={attributes.isLogged}
						onChange={(value) => setAttributes({ isLogged: value })}
					/>
					<CheckboxControl
						label="Restrict to admin access?"
						checked={attributes.isAdmin}
						onChange={(value) => setAttributes({ isAdmin: value })}
					/>
				</PanelBody>
				<PanelBody title="Redirect">
					<TextControl
						label="URL for redirect if access denied"
						value={attributes.editURL}
						onChange={(value) => setAttributes({ editURL: value })}
					/>
				</PanelBody>
			</InspectorControls>
			<div class="pz-page-access">
				<h3>This page will be available only to selected user roles. </h3>
			</div>
		</div>
	);
}
