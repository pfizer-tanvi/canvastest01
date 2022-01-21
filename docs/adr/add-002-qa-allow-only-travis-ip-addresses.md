# ADR 002 Allow only Travis IP addresses to access the QA login endpoint

## Context

We need to make sure that only travis ci can access the `_qa/login` endpoint for security purposes.

### People Involved in This Decision

- [Alfred](https://github.com/alnutile)

## Decision

Add a middle-ware that only allows request coming from IP addresses of Travis CI build machines.

## Status

- approved

### Relates to

- [CAP-2186](https://digitalpfizer.atlassian.net/browse/CAP-2186)
