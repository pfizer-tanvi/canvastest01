# ADR 001 Expose an HTTP RESTful QA login endpoint

## Context

Enable QA users to authenticate on staging directly from travis so that they can run tests before deploying to production.

### People Involved in This Decision

- [Alfred](https://github.com/alnutile)

## Decision

Expose a **POST** HTTP endpoint (qa/login) that automatically authenticates a QA user (qa@pfizer.com).
The user will be automatically created with configured defaults if they don't exist with a strong random password
This route will only be available in the staging environment

## Status

- pending
