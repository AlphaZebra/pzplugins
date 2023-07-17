/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from "@wordpress/block-editor";

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @return {WPElement} Element to render.
 */
export default function save({ attributes }) {
	// separate init function enqueues a javascript that reads cookie and sets cur person, product, whatever
	// if we haven't loaded the person array and cur_person is set, we should query person table for cur_person
	// and load a cur_person array with the values. Otherwise, we load a blank cur_person array.

	return (
		<div {...useBlockProps.save()}>
			<form action="" class="form-style-1">
				<li>
					<label>{attributes.prompt}</label>
					<input
						type="text"
						class="field-long"
						id={attributes.field}
						placeholder={attributes.field}
					/>
				</li>
			</form>
		</div>
	);
}
