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
