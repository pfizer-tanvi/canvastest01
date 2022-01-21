# ADR-004 - User Groups from AD

## Context

This is part of the effort to make a user management system that can be validated. This particular item will allow
web applications to use Active Directory Roles to manage the access of users.

When a user logs in they will have those groups attached to them made as roles and then be in those roles.

The developers can, ahead of time, program the Authorization of those roles.

### People Involved in This Decision
- Alfred Nutile


## Decision

Use https://spatie.be/docs/laravel-permission/v3/introduction we can get all the options we need with little code. All
this work will do is focus on

From there we will have a UI so admins can clearly see who is in one Group / Role BUT they can not edit that as part of this feature.

## Status
- In Progress


## Consequences
  * getting groups from cognito when the user logs in
  * adding those groups as roles
  * assigning the person to the role