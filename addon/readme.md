## JSON_LD ##
### ExpressionEngine JSON_LD Add-on ###


#### What will it do ####
Add JSON-LD to each page
Install, create database of types and fields
Choose schemas for site channels and appropriate fields/custom data
You will add json_ld tag to head
It will output automatic json_ld in script tags

#### How ####
EE Plugin
Plugin backend
Just a simple tag {exp:json_ld type="article"}

#### Available Schemas ####
Fetch full schemas from repo? Or updateable place?
Basic standard schemas

#### SITES ####
http://json-ld.org/
http://jsonld.com/
http://schema.org/


### JEREMY'S CODE ###
        {!-- "blog-post" json-ld template configured in cp and stored in db --}
        <script>
        ...
            "name" : '##token1##',
            "image": '##token2##'       
        ... 
        </script>

        {!-- In your site template, ie blog/entry or site/index --} 
        {exp:json_ld:set name="token1" template="blog-post"}{title}{/exp:json_ld:set}
        {exp:json_ld:set name="token2 template="blog-post"}{channel_images_field_name}{image}{/channel_images_field_name}{/exp:json_ld:set}

        
        {!-- in your wrapper --}
        {exp:json_ld:output template="blog-post"}

#### CODE EXAMPLES ####
EXAMPLE:

    <exp:json_ld>

becomes...

    <script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "Article",
        "headline": "Adding HTTPS to my Dreamhost WordPress site",
        "author": {
            "@type": "Person",
            "name": "Aaron T. Grogg"
        },
        "datePublished": "2015-12-11",
        "articleSection": "hosting",
        "url": "https://aarontgrogg.com/blog/2015/12/11/adding-https-to-my-dreamhost-wordpress-site/",
        "image": null,
        "publisher": {
            "@type": "Organization",
            "name": "Aaron T. Grogg"
        }
    }
    </script>

or...

    <script type="application/ld+json">
    { "@context": "http://schema.org", 
     "@type": "Article",
     "headline": "Extra! Extra! Read alla bout it",
     "alternativeHeadline": "This article is also about robots and stuff",
     "image": "http://example.com/image.jpg",
     "author": "Patrick Coombe", 
     "award": "Best article ever written",
     "editor": "Craig Mount", 
     "genre": "search engine optimization", 
     "keywords": "seo sales b2b", 
     "wordcount": "1120",
     "publisher": "Book Publisher Inc",
     "url": "http://www.example.com",
     "datePublished": "2015-09-20",
     "dateCreated": "2015-09-20",
     "dateModified": "2015-09-20",
     "description": "We love to do stuff to help people and stuff",
     "articleBody": "You can paste your entire post in here, and yes it can get really really long."
     }
    </script>

#### THINGS TO REMEMBER ####
Need to minify it
Should lint JSON

#### HOW IT WORKS ####
** Backend ** 
Each channel gets a type
Associate fields with type fields

** Frontend: **
Add field

#### SCHEMA FORMAT ####
    {
      "@id": "http://schema.org/",
      "@type": "Organization",
      "fields":
      [
        { "name": "", "type": "" },
      ]
    },

#### TYPES ####
Article
BlogPosting
NewsArticle
Report
ScholarlyArticle
TechArticle
Blog

CollectionPage
AboutPage
ContactPage
Person
VideoObject
AudioObject

## GOOGLE VALIDATION ##
Post to 
https://search.google.com/structured-data/testing-tool/validate

field:
html (accepts json)

returns:
### CORRECT ###

### ERROR ###
#### TYPE ERROR ###
        {
          "cse": [],
          "isRendered": false,
          "tripleGroups": [
            {
              "errorsByOwner": {
                "SPORE": 1
              },
              "warningsByOwner": {},
              "ownerSet": {
                "CORPORATE_CONTACTS": true
              },
              "nodes": [
                {
                  "types": [
                    {
                      "pred": "itemtype",
                      "value": "Organizdation",
                      "errors": [
                        {
                          "ownerSet": {
                            "SPORE": true
                          },
                          "errorType": "INVALID_ITEMTYPE",
                          "args": [
                            "Organizdation"
                          ],
                          "begin": 48,
                          "end": 254,
                          "isSevere": true,
                          "errorID": 0,
                          "ownerToSeverity": {
                            "SPORE": "ERROR"
                          }
                        }
                      ],
                      "begin": 48,
                      "end": 63
                    }
                  ],
                  "typeGroup": "Organizdation",
                  "errors": [],
                  "properties": [
                    {
                      "pred": "url",
                      "value": "http://www.google.com",
                      "errors": [],
                      "begin": 74,
                      "end": 97
                    },
                    {
                      "pred": "sameAs",
                      "value": "facebook.com",
                      "errors": [],
                      "begin": 111,
                      "end": 125
                    }
                  ],
                  "nodeProperties": [
                    {
                      "pred": "contactPoint",
                      "target": {
                        "types": [
                          {
                            "pred": "itemtype",
                            "value": "ContactPoint",
                            "errors": [],
                            "begin": 161,
                            "end": 175
                          }
                        ],
                        "typeGroup": "ContactPoint",
                        "errors": [],
                        "properties": [
                          {
                            "pred": "telephone",
                            "value": "+1-401-555-1212",
                            "errors": [],
                            "begin": 194,
                            "end": 211
                          },
                          {
                            "pred": "contactType",
                            "value": "customer service",
                            "errors": [],
                            "begin": 232,
                            "end": 250
                          }
                        ],
                        "nodeProperties": [],
                        "numErrors": 0,
                        "numWarnings": 0
                      },
                      "errors": [],
                      "begin": 146,
                      "end": 254
                    }
                  ],
                  "numErrors": 1,
                  "numWarnings": 0
                }
              ],
              "numNodesWithError": 1,
              "numNodesWithWarning": 0,
              "numErrors": 1,
              "numWarnings": 0,
              "type": "Organizdation"
            }
          ],
          "numObjects": 1,
          "html": "{\n  \"@context\": \"http://schema.org\",\n  \"@type\": \"Organizdation\",\n  \"url\": \"http://www.google.com\",\n  \"sameAs\": \"facebook.com\",\n  \"contactPoint\": [{\n    \"@type\": \"ContactPoint\",\n    \"telephone\": \"+1-401-555-1212\",\n    \"contactType\": \"customer service\"\n  }]\n}",
          "errors": [
            {
              "ownerSet": {
                "SPORE": true
              },
              "errorType": "INVALID_ITEMTYPE",
              "args": [
                "Organizdation"
              ],
              "begin": 48,
              "end": 254,
              "isSevere": true,
              "errorID": 0,
              "ownerToSeverity": {
                "SPORE": "ERROR"
              }
            }
          ],
          "totalNumErrors": 1,
          "totalNumWarnings": 0,
          "isValidForVoiceActions": false,
          "voiceActionsWriteAttempted": false,
          "voiceActionsWriteSuccessful": false,
          "isAppCardValidation": false,
          "isAtomXmlValidation": false
        }

#### FIELD TYPE ERROR ####
        {
          "cse": [],
          "isRendered": false,
          "tripleGroups": [
            {
              "errorsByOwner": {
                "SPORE": 1
              },
              "warningsByOwner": {},
              "ownerSet": {
                "CORPORATE_CONTACTS": true,
                "SOCIAL_PROFILES": true
              },
              "nodes": [
                {
                  "types": [
                    {
                      "pred": "itemtype",
                      "value": "Organization",
                      "errors": [],
                      "begin": 48,
                      "end": 62
                    }
                  ],
                  "typeGroup": "Organization",
                  "errors": [],
                  "properties": [
                    {
                      "pred": "url",
                      "value": "http://www.google.com",
                      "errors": [],
                      "begin": 73,
                      "end": 96
                    },
                    {
                      "pred": "sameAs",
                      "value": "facebook.com",
                      "errors": [],
                      "begin": 110,
                      "end": 124
                    }
                  ],
                  "nodeProperties": [
                    {
                      "pred": "contactPoint",
                      "target": {
                        "types": [
                          {
                            "pred": "itemtype",
                            "value": "ContactPoint",
                            "errors": [],
                            "begin": 160,
                            "end": 174
                          }
                        ],
                        "typeGroup": "ContactPoint",
                        "errors": [],
                        "properties": [
                          {
                            "pred": "kerflave",
                            "value": "gerbils",
                            "errors": [
                              {
                                "ownerSet": {
                                  "SPORE": true
                                },
                                "errorType": "INVALID_PREDICATE",
                                "args": [
                                  "kerflave",
                                  "ContactPoint"
                                ],
                                "begin": 188,
                                "end": 197,
                                "isSevere": true,
                                "errorID": 0,
                                "ownerToSeverity": {
                                  "SPORE": "ERROR"
                                }
                              }
                            ],
                            "begin": 188,
                            "end": 197
                          },
                          {
                            "pred": "telephone",
                            "value": "+1-401-555-1212",
                            "errors": [],
                            "begin": 216,
                            "end": 233
                          },
                          {
                            "pred": "contactType",
                            "value": "customer service",
                            "errors": [],
                            "begin": 254,
                            "end": 272
                          }
                        ],
                        "nodeProperties": [],
                        "numErrors": 0,
                        "numWarnings": 0
                      },
                      "errors": [],
                      "begin": 145,
                      "end": 276
                    }
                  ],
                  "numErrors": 1,
                  "numWarnings": 0
                }
              ],
              "numNodesWithError": 1,
              "numNodesWithWarning": 0,
              "numErrors": 1,
              "numWarnings": 0,
              "type": "Organization"
            }
          ],
          "numObjects": 1,
          "html": "{\n  \"@context\": \"http://schema.org\",\n  \"@type\": \"Organization\",\n  \"url\": \"http://www.google.com\",\n  \"sameAs\": \"facebook.com\",\n  \"contactPoint\": [{\n    \"@type\": \"ContactPoint\",\n\"kerflave\": \"gerbils\",    \n\"telephone\": \"+1-401-555-1212\",\n    \"contactType\": \"customer service\"\n  }]\n}",
          "errors": [
            {
              "ownerSet": {
                "SPORE": true
              },
              "errorType": "INVALID_PREDICATE",
              "args": [
                "kerflave",
                "ContactPoint"
              ],
              "begin": 188,
              "end": 197,
              "isSevere": true,
              "errorID": 0,
              "ownerToSeverity": {
                "SPORE": "ERROR"
              }
            }
          ],
          "totalNumErrors": 1,
          "totalNumWarnings": 0,
          "isValidForVoiceActions": false,
          "voiceActionsWriteAttempted": false,
          "voiceActionsWriteSuccessful": false,
          "isAppCardValidation": false,
          "isAtomXmlValidation": false
        }