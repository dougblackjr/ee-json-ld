![logo.png]

# JSON-LD Plugin for ExpressionEngine
> SEO-friendly schema generator for EE3
 
Create JSON-LD templates for your content, and insert them into your front-facing templates.

## Installing / Getting started

To install

1. Copy the json_ld folder within the ee_plugin folder to your `user/addons` folder.
2. Copy the json_ld folder within the ee_plugin_theme folder to your `public/themes/user` folder.
3. At your site admin panel, click `Developer`, then `Add-on Manager`.
4. Under the `Third Party Add-Ons` heading, click the JSON-LD install button.

You will then have access to create templates via the `Developer => Add-on Manager` menu at your site admin panel.

Please note: This creates one table in your database.

## Using JSON-LD
### Your Index View

When you first enter the JSON-LD plugin, you will see a list of your templates and a side menu. You have the options to:
+ Create New Template: Start a new JSON-LD template from scratch
+ Manage Templates: Edit or delete your JSON-LD templates
+ Documentation: View this file for further instructions.
+ Home: Return to this home view at any time.

### Create a JSON-LD template

First, from your Index view, click "Create New Template". This will bring you to the simple process this plugin follows.

1. *CHOOSE YOUR JSON-LD TYPE*: Choose the type of JSON-LD template that you would like to create, based on the content that you will demarcating with the template. When you select your type, the associated fields will appear, as well as a link to the schema.org documentation for that particular type.

2. *WORK YOUR FIELDS*: Choose a field you would like to add to your JSON-LD template from the Add Fields dropdown, then click the Add button. This will add that field to the form with a few important options:
    + *ADD TOKEN*: Since you will probably want to use dynamically created information in your JSON-LD template, you will be adding lots of these. Click the ADD TOKEN button next to a field to add a template token to the field. You can add whatever other text or as many other tokens to that field you would like.
    + *TOKEN FARM*: You will also notice the farm of your used tokens appear on the left. You can drag and drop these into the text fields you would like to use them in. A token can be used any amount of times.
    + *TEMPLATE FARM*: You can also nest templates into one another, for use of adding specific types.
        For example: An author can be a text field for a single name, a Person type, or an Organization. Let's say you want to create a Person type, and use it as your author. You create a template for Person type. That template will appear in the sidebar as you create your template. Drag and drop the template to the field you would like it to complete. The template will parse with tokens that you've placed and assign in your EE template, just as normal template.
    + *NEST*: Some JSON-LD fields contain entire other types. If you see the `NEST` button, you have the option of using a simple text input, or a nested field. Click the `NEST` button to access that sub-type's fields. You can add as many nested fields as you like by clicking the `NEST` button. You can add tokens to nested fields by clicking the plus sign in the appropriate box.

3. *RUN YOUR TEMPLATE*: This is where you get to see your data in action. Click the `Let's Go` button under the RUN TEMPLATE header to view your JSON-LD template. The information you entered on the form will appear, with your tokens and nested data.

4. *NAME YOUR TEMPLATE*: Give your JSON-LD template a unique name. You will need this name when you parse it in your EE template.

5. *SAVE YOUR TEMPLATE*: When you're all ready to go, click the `ADD TEMPLATE` button on the bottom of the page to save your template.

You can follow these same steps while editing your template. The form will parse your tokens so you can add new ones without overlap.

### Add your JSON-LD template to your EE template

After you've created your JSON-LD template, it's time to invisibily show it to the world.

You can have as many JSON-LD templates on your page as you would like

The JSON-LD template parser works with two tags: `set` and `output`.

##### SET
This command is used to parse your tokens, and should appear before the output command for the template the tokens belong to.

        {exp:json_ld:set token="1" template="Test1"}
        The title is {title}.
        {/exp:json_ld:set}

1. Open the set tag with `{exp:json_ld:set}`.
2. Set the token with the `token` parameter.
3. Set the template name with the `template` parameter.
4. Set your token data within the tag pair. This can be static text or other EE field information.
5. Close the tag with `{exp:json_ld:set}`.

This will set the tokens for use in the output command for the assigned template.

##### OUTPUT
This command is used in your EE template.

        {exp:json_ld:output template="Test1" test="1"}

        {exp:json_ld:output template="Test1|Test2|Test3" test="1"}

1. After you have set your tokens, use the `{exp:json_ld:output}` tag to enter the template.
2. Set the template name with the `template` parameter. You can use multiple templates by separating them with `|`.
3. JSON-LD as is will be invisible on your page, only to be picked up by crawlers. If you want to see your JSON-LD template in action, set the `test` parameter to `1` as displayed in the example above (Just make sure to take that out before you publish).


## JSON-LD Documentation

For more information on JSON-LD, see the following links:

[json-ld.org](http://json-ld.org)

[jsonld.com](http://jsonld.com)

[Google Schema - JSON-LD](https://developers.google.com/schemas/formats/json-ld)

[Google Schema Markup Validator (We'll integrate this soon)](https://search.google.com/structured-data/testing-tool/u/0/)

[W3 Standards](https://www.w3.org/TR/json-ld/)