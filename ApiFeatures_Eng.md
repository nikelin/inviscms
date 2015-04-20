# Overview #

The system allows developers to create the open and closed interfaces which will allow foreign appendices обращатся to internal procedures of a server. The server works on the basis of connected servers which, in turn, consist of atomic units - interfaces which on the basis of some entrance arguments included in inquiry, generates the certain contents as response.

As inquiry the **HTTP-inquiry**, with the instruction the identifier of the interface and arguments transferred in its context, as parameters of **POST/GET/FILES**-environments (depending on environment expected by the interface) is accepted.
The response of a server is presented by special image generated XML-given which come back as the **HTTP-response** in variable **POST** environment.

In a context of the organization of structure of a server and the interface with the purpose of standardization and the specification of everyone of interfaces, descriptive XML-files - **info.xml**, in which are used:
  1. The information on a current API-server is underlined
  1. Each separate interface the expected environment arguments is specified

During connection of the interface, before there is a processing and validation an information file.

# Details #

Methods for functioning a cursor of an API-server the package **api** which is responsible for processing entering inquiries, гененирование responses, and as delivers connection of API-interfaces by Wednesday of execution.

The object "Interface" can be described following structure:
The interface: {
> access: (public, internal),
> identifier,
> environment: [env1,..., envN],
> expected\_args: [.md](.md),
}

// GIVEN STORY IS NOT COMPLETED / / //