# Smart Links Redirector

[![Maintainability](https://api.codeclimate.com/v1/badges/b7d2e37e49840a9c7cdf/maintainability)](https://codeclimate.com/github/pozys/smart-link-redirector/maintainability)

[![Test](https://github.com/pozys/smart-link-redirector/actions/workflows/ci.yml/badge.svg)](https://github.com/pozys/smart-link-redirector/actions/workflows/ci.yml)

[![Test Coverage](https://api.codeclimate.com/v1/badges/b7d2e37e49840a9c7cdf/test_coverage)](https://codeclimate.com/github/pozys/smart-link-redirector/test_coverage)

**Sequence Diagram**

```mermaid
  sequenceDiagram
    RedirectResolverInterface->>+RedirectLinkRepositoryInterface: findRedirects(LinkInterface)
    RedirectLinkRepositoryInterface->>-RedirectResolverInterface: array<RedirectLinkInterface>
    loop RedirectLinkInterface
        RedirectResolverInterface->>+RedirectLinkInterface: getRules()
        RedirectLinkInterface->>-RedirectResolverInterface: array<ConditionInterface>
        RedirectResolverInterface->>+ComparatorInterface: isApplicable(array<ConditionInterface>)
        loop ConditionInterface
        ComparatorInterface->>+ConditionInterface:isSatisfied()
        ConditionInterface->>+HasConditionsInterface:conditions()
        HasConditionsInterface->>-ConditionInterface:array<ConditionInterface>
            loop ConditionInterface
                ConditionInterface->>+AnotherConditionInterface:isSatisfied()
                AnotherConditionInterface->>+CanProvideValueInterface:getValue()
                CanProvideValueInterface->>-AnotherConditionInterface:mixed
                AnotherConditionInterface->>-ConditionInterface:bool
            end

        ConditionInterface->>-ComparatorInterface:isSatisfied()
        end
        ComparatorInterface->>-RedirectResolverInterface: bool
    end

    Note over RedirectResolverInterface,ComparatorInterface: Выбираем первый RedirectLinkInterface,
    Note over RedirectResolverInterface,ComparatorInterface: для которого ComparatorInterface вернёт true (все правила истинны)
```

**C4 Diagram**

```mermaid
C4Context
      title System Context diagram for Smart Links Service
      Enterprise_Boundary(c0, "") {
        Person(Client, "Smart Links Service Customer")

        Container_Boundary(c1, "Redirector") {
            Container(Redirector-web-server, "Web Server", "nginx")

            Container(Redirector-application, "Redirector", "PHP 8.4, Laravel 12", "Resolve links")

            ContainerDb(Redirector-database, "Redirector Database", "PostgreSQL")

            Container(Auth-Server-web-server, "Web Server", "nginx")

            Container(Auth-Server-application, "Auth Server", "PHP 8.4, Laravel 12", "Provide Authentication/Authorization")

            ContainerDb(Auth-Server-database, "Auth Server Database", "PostgreSQL")
        }
      }

        BiRel(Client, Redirector-web-server, "Follows the link")
        BiRel(Redirector-web-server, Redirector-application, "")
        BiRel(Redirector-application, Redirector-database, "")
        BiRel(Redirector-application, Auth-Server-web-server, "request auth")
        BiRel(Auth-Server-web-server, Auth-Server-application, "")
        BiRel(Auth-Server-application, Auth-Server-database, "")

      UpdateLayoutConfig($c4ShapeInRow="3", $c4BoundaryInRow="1")
```
