# Extract QA Automation to a separate library

## Context

We need an easy way to pull in the QA features in other la-ravel projects and be ready ready go.

### People Involved in This Decision

- Alfred Nutile
- Ahimbisibwe Roland

## Decision

Extract qa-automation directory to a separate repo and install it as a composer package.

## Status

- approved

## Consequences

- Package will have to be installed first in order to be used.
- Library exposes a command that publishes a configuration file that can be used to customize qa automation user
